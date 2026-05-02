<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class ShowUserPageController extends BaseController
{
    public function index()
    {
        //
    }

    public function fetchUser($id)
    {
        if (!session()->get('userId')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        $model = new UserModel();

        $user = $model->find($id);

        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => 'User not Found.'
            ]);
        }

        return view('admin/show-user', ['user' => $user]);
    }

    public function fetchUserProfile($id)
    {
        if (!session()->get('userId')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        $model = new UserModel();

        $user = $model->select('id, firstname, lastname, middlename, suffix, age, sex, username, img, role, isActive')->find($id);

        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => 'User not Found.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function changePass()
    {
        if (!session()->get('userId')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        $model = new UserModel();

        $old_pass = $this->request->getPost('old_pass');
        $new_pass = $this->request->getPost('new_pass');
        $id = $this->request->getPost('id');

        $validation = Services::validation();
        $validation->setRules([
            'old_pass' => [
                'label' => 'Old Password',
                'rules' => 'required|max_length[20]'
            ],

            'new_pass' => [
                'label' => 'New Password',
                'rules' => 'required|max_length[20]'
            ],
            'id' => 'required|integer',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }


        $user = $model->find($id);

        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => [
                    'old_pass' => 'User not found.'
                ]
            ]);
        }

        if (!password_verify($old_pass, $user['password'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => [
                    'old_pass' => 'Incorrect old password.'
                ]
            ]);
        }

        $update = $model->update($id, [
            'password' => password_hash($new_pass, PASSWORD_DEFAULT)
        ]);

        if (!$update) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => [
                    'new_pass' => 'Failed to change a new password.'
                ]
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Password changed successfully.'
        ]);
    }

    public function uploadPhoto()
    {
        if (!session()->get('userId')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        $model = new UserModel();
        $id = $this->request->getPost('id');
        $img = $this->request->getFile('img');

        // Find user
        $user = $model->find($id);
        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User not found.'
            ]);
        }

        // Validate uploaded file
        if (!$img->isValid()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No file uploaded or invalid file.'
            ]);
        }

        if (!in_array($img->getExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid file type. Only JPG, PNG, GIF allowed.'
            ]);
        }

        // Delete old image if exists and is not default
        if (!empty($user['img'])) {
            $oldFile = FCPATH . str_replace(base_url(), '', $user['img']); // convert URL to file path
            if (file_exists($oldFile) && basename($oldFile) !== 'no_profile.jpg') {
                unlink($oldFile);
            }
        }

        // Save new image
        $newName = $img->getRandomName();
        $img->move(FCPATH . 'uploads/avatar/', $newName);

        // Save new path in database
        $imgUrl = base_url('uploads/avatar/' . $newName);
        $model->update($id, ['img' => $imgUrl]);

        return $this->response->setJSON([
            'status' => 'success',
            'img_url' => $imgUrl,
            'message' => 'Profile photo updated successfully.'
        ]);
    }

    public function updateInfo()
    {
        if (!session()->get('userId')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        $model = new UserModel();

        // Get POST data
        $id = $this->request->getPost('id');
        $firstname = $this->request->getPost('firstname');
        $lastname = $this->request->getPost('lastname');
        $middlename = $this->request->getPost('middlename');
        $suffix = $this->request->getPost('suffix');
        $age = $this->request->getPost('age');
        $sex = $this->request->getPost('sex');
        $username = $this->request->getPost('username');
        $role = $this->request->getPost('role');
        $isActive = $this->request->getPost('isActive');

        // Find user
        $user = $model->find($id);
        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User not found.'
            ]);
        }

        // Validation rules
        $validation = Services::validation();
        $validation->setRules([
            'firstname' => 'required|max_length[50]',
            'lastname' => 'required|max_length[50]',
            'middlename' => 'max_length[50]',
            'suffix' => 'max_length[10]',
            'age' => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[150]',
            'sex' => 'required|in_list[male,female]',
            'username' => 'required|max_length[50]|is_unique[users.username,id,' . $id . ']',
            'role' => 'required|in_list[user,admin]',
            'isActive' => 'required|in_list[0,1]'
        ]);

        $postData = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'middlename' => $middlename,
            'suffix' => $suffix,
            'age' => $age,
            'sex' => $sex,
            'username' => $username,
            'role' => $role,
            'isActive' => $isActive
        ];

        if (!$validation->run($postData)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        // Update user
        $model->update($id, $postData);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'User information updated successfully.'
        ]);
    }
}
