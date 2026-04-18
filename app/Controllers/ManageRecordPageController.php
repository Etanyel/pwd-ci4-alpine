<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PersonsModel;
use CodeIgniter\HTTP\ResponseInterface;

class ManageRecordPageController extends BaseController
{
    public function index()
    {
        return view('admin/manage-record');
    }

    public function fetchRecords()
    {
        try {
            $model = new PersonsModel();
        $records = $model->findAll();

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $records
        ]);
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $e->getMessage()
            ]);
        }
    }
}
