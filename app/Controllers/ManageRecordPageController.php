<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PersonsModel;
use CodeIgniter\HTTP\ResponseInterface;

class ManageRecordPageController extends BaseController
{
    public function index()
    {
        return view('admin/manage-records');
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


    public function manageRecord($id)
    {
        $model = new PersonsModel();
        $record = $model->find($id);
        if (!$record) {
            return redirect()->back()->with('error', 'Record not found');
        }

        return view('admin/manage-record', ['record' => $record]);    
    }

    public function fetchRecord($id)
    {
        try {
            $model = new PersonsModel();
            $record = $model->find($id);

        if (!$record) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => 'Record not found'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $record
        ]);
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $e->getMessage()
            ]);
        }
    }

    
}
