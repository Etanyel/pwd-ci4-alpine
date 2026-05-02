<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class UserPageController extends BaseController
{
    public function index()
    {
        return view('user/user-dashboard');
    }

    public function fetchUsers()
    {
        if (!session()->get('userId')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        $model = new UserModel();

        $data = $model->select('id, firstname, lastname, middlename, username, isActive, role, created_at')->findAll();

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
