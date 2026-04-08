<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CauseOfDisability;
use App\Models\DisabilityType;
use CodeIgniter\HTTP\ResponseInterface;

class AddRecordPageController extends BaseController
{
    public function index()
    {
        return view('admin/add-record');
    }

    public function fetchCause($num)
    {
        $model = new CauseOfDisability;

        if ($num > 2) {
            return $this->response->setJSON([
                'status' => 'error'
            ]);
        }

        $cause = null;
        if ($num == 2) {
            $cause = 0;
        } else {
            $cause = 1;
        }


        return $this->response->setJSON([
            'status' => 'success',
            'cause' => $model->where('cause', $cause)->findAll()
        ]);
    }

    public function fetchDisability()
    {
        try {
            $model = new DisabilityType;

            return $this->response->setJSON([
                'status' => 'success',
                'data' => $model->findAll()
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'error' => $e->getMessage()
            ]);
        }
    }
}
