<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangayModel;
use App\Models\CauseOfDisability;
use App\Models\CityModel;
use App\Models\DisabilityType;
use App\Models\PersonsModel;
use App\Models\ProvinceModel;
use App\Models\RegionModel;
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

    public function fetchOccupation()
    {
        try {
            $model = db_connect()->table('person_occupation');
            $occupation = $model->get()->getResultArray();

            return $this->response->setStatusCode(200)->setJSON([
                'status' => 'success',
                'data' => $occupation
            ]);
        } catch (\Throwable $e) {
            log_message('error', $e->getMessage());

            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'Failed to fetch occupation.'
            ]);
        }
    }


    public function addRecord()
    {
        try {
            $model = new PersonsModel();
            $regionModel = new RegionModel();
            $provinceModel = new ProvinceModel();
            $cityModel = new CityModel();
            $barangayModel = new BarangayModel();

            $req = $this->request;
            $region = $req->getPost('region');
            $province = $req->getPost('province');
            $city = $req->getPost('city');
            $barangay = $req->getPost('barangay');

            $region_find = $regionModel->where('code', $region)->first();
            $province_find = $provinceModel->where('code', $province)->first();
            $city_find = $provinceModel->where('code', $city)->first();
            $barangay_find = $provinceModel->where('code', $barangay)->first();


            // build data manually (controlled)
            $data = [
                'pwd_no' => $req->getPost('pwd_no'),
                'lastname' => $req->getPost('lastname'),
                'firstname' => $req->getPost('firstname'),
                'middlename' => $req->getPost('middlename'),
                'suffix' => $req->getPost('suffix'),
                'sex' => $req->getPost('sex'),
                'age' => $req->getPost('age'),

                'street_name' => strtoupper($req->getPost('street_name')),

                'birthdate' => $req->getPost('birthdate'),
                'mobile_no' => $req->getPost('mobile_no'),
                'email' => $req->getPost('email'),
                'landline' => $req->getPost('landline'),

                'type_of_disability' => $req->getPost('type_of_disability'),
                'cause_of_disability' => $req->getPost('cause_of_disability'),
                'other_cause' => $req->getPost('other_cause'),

                'civil_status' => $req->getPost('civil_status'),
                'employment_status' => $req->getPost('employment_status'),
                'educational_attainment' => $req->getPost('educational_attainment'),
                'category_of_employment' => $req->getPost('category_of_employment'),
                'nature_of_employment' => $req->getPost('nature_of_employment'),

                'occupation' => $req->getPost('occupation'),
                'other_occupation' => $req->getPost('other_occupation'),

                'bloodtype' => $req->getPost('bloodtype'),
                'organization_affliated' => $req->getPost('organization_affliated'),
                'office_address' => $req->getPost('office_address'),
                'contact_person' => $req->getPost('contact_person'),

                'sss_no' => $req->getPost('sss_no'),
                'gsis_no' => $req->getPost('gsis_no'),
                'psn_no' => $req->getPost('psn_no'),
                'philhealth_no' => $req->getPost('philhealth_no'),

                // 🔥 combine parents name (since DB only has one field)
                'fathers_name' => trim(
                    $req->getPost('fathers_firstname') . ' ' .
                        $req->getPost('fathers_middlename') . ' ' .
                        $req->getPost('fathers_lastname')
                ),

                'mothers_name' => trim(
                    $req->getPost('mothers_firstname') . ' ' .
                        $req->getPost('mothers_middlename') . ' ' .
                        $req->getPost('mothers_lastname')
                ),

                'date_applied' => $req->getPost('date_applied'),
            ];

            $data['region'] = strtoupper($region_find['region_name']);
            $data['province'] = strtoupper($province_find['name']);
            $data['city_municipality'] = strtoupper($city_find['name']);
            $data['barangay'] = strtoupper($barangay_find['name']);

            // remove null / empty (optional but clean)
            // $data = array_filter($data, fn($v) => $v !== null && $v !== '');


            $model->insert($data);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'New Record added Successfully.'
            ]);
        } catch (\Throwable $e) {

            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $e->getMessage(),
            ]);
        }
    }
}
