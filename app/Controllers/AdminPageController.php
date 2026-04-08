<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AdminPageController extends BaseController
{
    public function index()
    {
        return view('admin/admin-dashboard');
    }


    public function manageUserPage()
    {
        return view('admin/manage-user');
    }
}
