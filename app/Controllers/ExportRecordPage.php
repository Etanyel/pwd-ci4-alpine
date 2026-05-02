<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ExportRecordPage extends BaseController
{
    public function index()
    {
        return view('admin/export-records');
    }
}
