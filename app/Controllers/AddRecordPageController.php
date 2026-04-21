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
use Config\Services;

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
            $city_find = $cityModel->where('code', $city)->first();
            $barangay_find = $barangayModel->where('code', $barangay)->first();

            if (!$region_find || !$province_find || !$city_find || !$barangay_find) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => 'Invalid region, province, city, or barangay selected.',
                ]);
            }


            // build data manually (controlled)
            $data = [
                'pwd_no' => $req->getPost('pwd_no'),
                'lastname' => strtoupper($req->getPost('lastname')),
                'firstname' => strtoupper($req->getPost('firstname')),
                'middlename' => strtoupper($req->getPost('middlename')),
                'suffix' => strtoupper($req->getPost('suffix')),
                'sex' => $req->getPost('sex'),
                'age' => $req->getPost('age'),

                'street_name' => strtoupper($req->getPost('street_name')),

                'birthdate' => $req->getPost('birthdate'),
                'mobile_no' => $req->getPost('mobile_no'),
                'email' => $req->getPost('email'),
                'landline' => $req->getPost('landline'),

                'type_of_disability' => $req->getPost('type_of_disability'),
                'cause_of_disability' => $req->getPost('cause'),
                'cause_of' => $req->getPost('cause_of'),
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

                // Combine the father's lastname, firstname, and middlename
                'fathers_name' => trim(
                    strtoupper($req->getPost('fathers_firstname')) . ' ' .
                        strtoupper($req->getPost('fathers_middlename')) . ' ' .
                        strtoupper($req->getPost('fathers_lastname'))
                ) ?: null,

                // Combine the lastname, firstname, and middlename
                'mothers_name' => trim(
                    strtoupper($req->getPost('mothers_firstname')) . ' ' .
                        strtoupper($req->getPost('mothers_middlename')) . ' ' .
                        strtoupper($req->getPost('mothers_lastname'))
                ) ?: null,

                'date_applied' => $req->getPost('date_applied'),
            ];

            $data['region'] = strtoupper($region_find['region_name']);
            $data['province'] = strtoupper($province_find['name']);
            $data['city_municipality'] = strtoupper($city_find['name']);
            $data['barangay'] = strtoupper($barangay_find['name']);

            // Set defaults for optional fields
            $data['bloodtype'] = $data['bloodtype'] ?: 'A+';
            $data['organization_affliated'] = $data['organization_affliated'] ?: 'None';
            $data['office_address'] = $data['office_address'] ?: 'None';
            $data['contact_person'] = $data['contact_person'] ?: 'None';

            $validation = Services::validation();

            $validation->setRules([
                'pwd_no' => [
                    'label' => 'PWD Number',
                    'rules' => 'required|max_length[20]|is_unique[persons.pwd_no]',
                ],
                'lastname' => [
                    'label' => 'Last Name',
                    'rules' => 'required|max_length[50]',
                ],

                'firstname' => [
                    'label' => 'First Name',
                    'rules' => 'required|max_length[50]',
                ],

                'middlename' => [
                    'label' => 'Middle Name',
                    'rules' => 'permit_empty|max_length[50]',
                ],

                'suffix' => [
                    'label' => 'Suffix',
                    'rules' => 'permit_empty|max_length[10]',
                ],

                'sex' => [
                    'label' => 'Sex',
                    'rules' => 'required|in_list[male,female]',
                ],
                'age' => [
                    'label' => 'Age',
                    'rules' => 'required|integer|min_length[0]|less_than[150]',
                ],
                'date_applied' => [
                    'label' => 'Date Applied',
                    'rules' => 'required|valid_date',
                ],
                'type_of_disability' => [
                    'label' => 'Type of Disability',
                    'rules' => 'required',
                ],
                'cause_of_disability' => [
                    'label' => 'Cause of Disability',
                    'rules' => 'required',
                ],
                'other_cause' => [
                    'label' => 'Other Cause',
                    'rules' => 'permit_empty|max_length[100]',
                ],
                'region' => [
                    'label' => 'Region',
                    'rules' => 'required|max_length[100]',
                ],
                'province' => [
                    'label' => 'Province',
                    'rules' => 'required|max_length[100]',
                ],
                'city_municipality' => [
                    'label' => 'City/Municipality',
                    'rules' => 'required|max_length[100]',
                ],
                'barangay' => [
                    'label' => 'Barangay',
                    'rules' => 'required|max_length[100]',
                ],
                'street_name' => [
                    'label' => 'Street Name',
                    'rules' => 'required|max_length[250]',
                ],
                'birthdate' => [
                    'label' => 'Birthdate',
                    'rules' => 'required|valid_date',
                ],
                'civil_status' => [
                    'label' => 'Civil Status',
                    'rules' => 'required|integer',
                ],
                'educational_attainment' => [
                    'label' => 'Educational Attainment',
                    'rules' => 'required|integer',
                ],
                'employment_status' => [
                    'label' => 'Employment Status',
                    'rules' => 'required|integer',
                ],
                'category_of_employment' => [
                    'label' => 'Category of Employment',
                    'rules' => 'permit_empty|integer',
                ],
                'nature_of_employment' => [
                    'label' => 'Nature of Employment',
                    'rules' => 'required|integer',
                ],
                'occupation' => [
                    'label' => 'Occupation',
                    'rules' => 'permit_empty|integer',
                ],
                'other_occupation' => [
                    'label' => 'Other Occupation',
                    'rules' => 'permit_empty|max_length[250]',
                ],
                'bloodtype' => [
                    'label' => 'Blood Type',
                    'rules' => 'permit_empty|in_list[A+,A-,B+,B-,O+,O-,AB+,AB-]',
                ],
                'organization_affliated' => [
                    'label' => 'Organization Affiliated',
                    'rules' => 'permit_empty|max_length[250]',
                ],
                'office_address' => [
                    'label' => 'Office Address',
                    'rules' => 'permit_empty|max_length[250]',
                ],
                'contact_person' => [
                    'label' => 'Contact Person',
                    'rules' => 'permit_empty|max_length[150]',
                ],
                'sss_no' => [
                    'label' => 'SSS Number',
                    'rules' => 'permit_empty|max_length[100]',
                ],
                'gsis_no' => [
                    'label' => 'GSIS Number',
                    'rules' => 'permit_empty|max_length[100]',
                ],
                'psn_no' => [
                    'label' => 'PSN Number',
                    'rules' => 'permit_empty|max_length[100]',
                ],
                'philhealth_no' => [
                    'label' => 'PhilHealth Number',
                    'rules' => 'permit_empty|max_length[100]',
                ],
                'fathers_name' => [
                    'label' => 'Father\'s Name',
                    'rules' => 'permit_empty|max_length[200]',
                ],
                'mothers_name' => [
                    'label' => 'Mother\'s Name',
                    'rules' => 'permit_empty|max_length[200]',
                ],
            ]);

            if (!$validation->run($data)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $validation->getErrors(),
                ]);
            }
            // remove null / empty (optional but clean)
            // $data = array_filter($data, fn($v) => $v !== null && $v !== '');

            $model->insert($data);

            $person_new = $model->where('pwd_no', $data['pwd_no'])->first();
            service('activitylog')->save([
                'user_id' => session()->get('userId'),
                'tag_id' => $person_new['id'],
                'user_agent' => service('request')->getUserAgent()->getAgentString(),
                'ip_address' => service('request')->getIPAddress(),
                'action' => 'Added new record',
                'tag' => 'MEMBER'
            ]);

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
