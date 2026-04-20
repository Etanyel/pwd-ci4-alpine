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
        $record = $model->select('persons.*, person_disability.disability, cause_of_disability.title, person_occupation.occupation_name')
            ->join('person_disability', 'person_disability.disability_id = persons.type_of_disability')
            ->join('cause_of_disability', 'cause_of_disability.disability_id = persons.cause_of_disability')
            ->join('person_occupation', 'person_occupation.occupation_id = persons.occupation')
            ->where('persons.id', $id)->first();
        // $record = $model->find($id);
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

    public function updateRecord($id = null)
    {
        try {
            $request = service('request');

            if (!$id) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => 'Invalid record ID'
                ]);
            }

            $model = new PersonsModel();

            // Get old record
            $old = $model->find($id);
            if (!$old) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => 'Record not found'
                ]);
            }

            // New data from request
            $data = [
                'pwd_no' => $request->getPost('pwd_no'),
                'date_applied' => $request->getPost('date_applied'),
                'lastname' => strtoupper($request->getPost('lastname')),
                'firstname' => strtoupper($request->getPost('firstname')),
                'middlename' => strtoupper($request->getPost('middlename')),
                'suffix' => strtoupper($request->getPost('suffix')),
                'type_of_disability' => $request->getPost('type_of_disability'),
                'cause' => $request->getPost('cause'),
                'other_cause' => $request->getPost('other_cause'),
                'region' => $request->getPost('region'),
                'province' => $request->getPost('province'),
                'city' => $request->getPost('city'),
                'barangay' => $request->getPost('barangay'),
                'street_name' => $request->getPost('street_name'),
                'landline' => $request->getPost('landline'),
                'mobile_no' => $request->getPost('mobile_no'),
                'email' => $request->getPost('email'),
                'birthdate' => $request->getPost('birthdate'),
                'age' => $request->getPost('age'),
                'sex' => $request->getPost('sex'),
                'civil_status' => $request->getPost('civil_status'),
                'educational_attainment' => $request->getPost('educational_attainment'),
                'employment_status' => $request->getPost('employment_status'),
                'category_of_employment' => $request->getPost('category_of_employment'),
                'nature_of_employment' => $request->getPost('nature_of_employment'),
                'occupation' => $request->getPost('occupation'),
                'other_occupation' => $request->getPost('other_occupation'),
                'bloodtype' => $request->getPost('bloodtype'),
                'organization_affliated' => $request->getPost('organization_affliated'),
                'office_address' => $request->getPost('office_address'),
                'contact_person' => $request->getPost('contact_person'),
                'sss_no' => $request->getPost('sss_no'),
                'gsis_no' => $request->getPost('gsis_no'),
                'psn_no' => $request->getPost('psn_no'),
                'philhealth_no' => $request->getPost('philhealth_no'),
                'fathers_name' => strtoupper($request->getPost('fathers_firstname') . " " . $request->getPost('fathers_middlename') . ". " . $request->getPost('fathers_lastname')),
                'mothers_name' => strtoupper($request->getPost('mothers_firstname') . " " . $request->getPost('mothers_middlename') . ". " . $request->getPost('mothers_lastname')),
            ];

            // VALIDATION RULES
            $validationRules = [
                'pwd_no' => 'required',
                'lastname' => 'required|min_length[2]',
                'firstname' => 'required|min_length[2]',
                'mobile_no' => 'permit_empty|max_length[11]',
                'email' => 'permit_empty|valid_email',
                'birthdate' => 'required|valid_date',
                'sex' => 'required',
            ];

            if (!$this->validate($validationRules)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $this->validator->getErrors()
                ]);
            }

            // ✅ COMPARE OLD VS NEW
            $changes = [];

            foreach ($data as $field => $newValue) {
                $oldValue = $old[$field] ?? null;

                // Normalize for comparison
                if ((string)$oldValue !== (string)$newValue) {
                    $changes[] = "$field: {$oldValue} → {$newValue}";
                }
            }

            // Update record
            $model->update($id, $data);

            // ✅ ACTIVITY LOG MESSAGE
            $actionText = 'Updated record';

            if (!empty($changes)) {
                $actionText .= ' (' . implode(', ', $changes) . ')';
            }

            $newRec = $model->where('pwd_no', $data['pwd_no'])->first();

            service('activitylog')->save([
                'user_id' => session()->get('userId'),
                'tag_id' => $newRec['id'],
                'user_agent' => $request->getUserAgent()->getAgentString(),
                'ip_address' => $request->getIPAddress(),
                'action' => $actionText,
                'tag' => 'MEMBER'
            ]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Record updated successfully',
                'changes' => $changes // optional (for debugging/UI)
            ]);
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function uploadPhoto()
    {
        $model = new PersonsModel();
        $id = $this->request->getPost('id');
        $img = $this->request->getFile('img');

        // Find user
        $user = $model->find($id);
        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User not found.'
            ]);
        }

        // Validate uploaded file
        if (!$img->isValid()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No file uploaded or invalid file.'
            ]);
        }

        if (!in_array($img->getExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid file type. Only JPG, PNG, GIF allowed.'
            ]);
        }

        // Delete old image if exists and is not default
        if (!empty($user['img'])) {
            $oldFile = FCPATH . str_replace(base_url(), '', $user['img']); // convert URL to file path
            if (file_exists($oldFile) && basename($oldFile) !== 'no_profile.jpg') {
                unlink($oldFile);
            }
        }

        // Save new image
        $newName = $img->getRandomName();
        $img->move(FCPATH . 'uploads/persons/' . $user['id'] . '/', $newName);

        // Save new path in database
        $imgUrl = base_url('uploads/persons/' . $user['id'] . '/' . $newName);
        $model->update($id, ['img' => $imgUrl]);

        service('activitylog')->save([
            'user_id' => session()->get('userId'),
            'tag_id' => $user['id'],
            'user_agent' => service('request')->getUserAgent()->getAgentString(),
            'ip_address' => service('request')->getIPAddress(),
            'action' => 'Uploaded Photo',
            'tag' => 'MEMBER'
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'img_url' => $imgUrl,
            'message' => 'Profile photo updated successfully.'
        ]);
    }
}
