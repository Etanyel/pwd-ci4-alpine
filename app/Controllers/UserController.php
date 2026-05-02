<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class UserController extends BaseController
{
    public function index()
    {
        //
    }

    public function registerUser()
    {
        if (!session()->get('userId')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        $model = new UserModel();

        $img = $this->request->getFile('img');
        $filename = null;

        if ($img && $img->isValid()) {
            $filename = $img->getRandomName();
        }

        $data = [
            'firstname' => $this->request->getPost('firstname'),
            'lastname' => $this->request->getPost('lastname'),
            'middlename' => $this->request->getPost('middlename'),
            'suffix' => $this->request->getPost('suffix'),
            'age' => $this->request->getPost('age'),
            'sex' => $this->request->getPost('sex'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'img' => $filename,
            'role' => $this->request->getPost('role'),
        ];

        $validation = Services::validation();
        $validation->setRules([
            'firstname' => 'required|max_length[50]|min_length[2]',
            'lastname' => 'required|max_length[50]|min_length[2]',
            'middlename' => 'permit_empty|max_length[50]|min_length[2]',
            'suffix' => 'permit_empty|max_length[10]',
            'age' => 'required|integer|greater_than[0]|less_than[150]',
            'sex' => 'required|in_list[male, female]',
            'username' => 'required|max_length[50]|min_length[3]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'img' => 'permit_empty|max_size[img,10240]|mime_in[img,image/png,image/jpeg,image/jpg,image/webp,image/gif]',
            'role' => 'required|in_list[admin,user]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors(),
                'csrf_token' => csrf_hash(),
                'csrf_name' => csrf_token()
            ]);
        }

        if ($img && $img->isValid() && !$img->hasMoved()) {
            $img->move('uploads/avatar', $filename);
        }

        if (!$model->save($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => 'Failed to the user.',
                'csrf_token' => csrf_hash(),
                'csrf_name' => csrf_token()
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'User added.',
            'csrf_token' => csrf_hash(),
            'csrf_name' => csrf_token()
        ]);
    }
}
