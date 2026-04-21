<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class AuthController extends BaseController
{
    public function login()
    {
        $model = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $validation = Services::validation();

        $validation->setRules([
            'username' => 'required|max_length[50]|min_length[3]',
            'password' => 'required|max_length[50]|min_length[6]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        $user = $model->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            if ($user['isActive'] == 1) {
                $session = session();

                service('activitylog')->save([
                    'user_id' => $user['id'],
                    'tag_id' => null,
                    'user_agent' => service('request')->getUserAgent()->getAgentString(),
                    'ip_address' => service('request')->getIPAddress(),
                    'action' => 'Logged In',
                    'tag' => 'AUTH'
                ]);

                $session->set([
                    'userRole' => $user['role'],
                    'userId' => $user['id'],
                    'user_firstname' => $user['firstname'],
                    'user_lastname' => $user['lastname'],
                    'user_img' => $user['img'],
                    'isLoggedIn' => true,
                ]);

                $session->regenerate();

                return $this->response->setJSON([
                    'status' => 'success',
                    'role' => $user['role'],
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => [
                        'username' => 'This account is inactive. Please contact the administrator.'
                    ]
                ]);
            }
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => [
                    'username' => 'Invalid Credentials.',
                    'password' => 'Invalid Credentials.'
                ]
            ]);
        }
    }

    public function logout()
    {
        service('activitylog')->save([
            'user_id' => session()->get('userId'),
            'tag_id' => null,
            'user_agent' => service('request')->getUserAgent()->getAgentString(),
            'ip_address' => service('request')->getIPAddress(),
            'action' => 'Logged Out',
            'tag' => 'AUTH'
        ]);
        session()->destroy();
        return redirect()->to('/');
    }
}
