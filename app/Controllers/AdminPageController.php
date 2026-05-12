<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PersonsModel;
use CodeIgniter\HTTP\ResponseInterface;

class AdminPageController extends BaseController
{
    public function index()
    {
        if (!session()->get('userId')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        $model = new PersonsModel();
        $presentMonth = date('m');
        $persons = $model->select('id, pwd_no, lastname, firstname, middlename, suffix, birthdate, age, sex, barangay, street_name, created_at')->where('MONTH(created_at)', $presentMonth)->findAll();

        return view('admin/admin-dashboard', ['persons' => $persons]);
    }


    public function manageUserPage()
    {
        if (!session()->get('userId')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized access.'
            ])->setStatusCode(403);
        }

        return view('admin/manage-user');
    }
}
