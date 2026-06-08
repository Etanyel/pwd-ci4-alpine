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

        // Pagination configuration
        $page = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 20; // Records per page
        $offset = ($page - 1) * $perPage;

        // Get total records count for the current month
        $totalRecords = $model->select('id')
            ->where('MONTH(created_at)', $presentMonth)
            ->countAllResults(false);

        // Get paginated records
        $persons = $model->select('id, pwd_no, lastname, firstname, middlename, suffix, birthdate, age, sex, barangay, street_name, created_at')
            ->where('MONTH(created_at)', $presentMonth)
            ->orderBy('created_at', 'DESC')
            ->findAll($perPage, $offset);

        // Calculate total pages
        $totalPages = ceil($totalRecords / $perPage);

        return view('admin/admin-dashboard', [
            'persons' => $persons,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total_records' => $totalRecords,
                'total_pages' => $totalPages
            ]
        ]);
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
