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
            $search = $this->request->getGet('search');
            $model = new PersonsModel();

            if ($search != '') {
                $model->groupStart()
                    ->like('lastname', $search)
                    ->orLike('firstname', $search)
                    ->orLike('pwd_no', $search)
                    ->groupEnd();
            }

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
            ->join('person_occupation', 'person_occupation.occupation_id = persons.occupation')
            ->join('cause_of_disability', 'cause_of_disability.cause_id = persons.cause_of_disability')
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
            $record = $model->select('persons.*, person_disability.disability, cause_of_disability.title, person_occupation.occupation_name')
                ->join('person_disability', 'person_disability.disability_id = persons.type_of_disability')
                ->join('person_occupation', 'person_occupation.occupation_id = persons.occupation')
                ->join('cause_of_disability', 'cause_of_disability.cause_id = persons.cause_of_disability')
                ->where('persons.id', $id)->first();
            // $record = $model->find($id);

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
                    'errors' => ['Invalid record ID'],
                    'csrf_token' => csrf_hash()
                ]);
            }

            $model = new PersonsModel();

            // Get old record
            $old = $model->find($id);
            if (!$old) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => ['Record not found'],
                    'csrf_token' => csrf_hash()
                ]);
            }

            // Helper function to build parent name (only if any field has value)
            $buildParentName = function ($firstname, $middlename, $lastname) {
                $firstname = trim($firstname ?? '');
                $middlename = trim($middlename ?? '');
                $lastname = trim($lastname ?? '');

                // Return null if all fields are empty (so no update occurs)
                if (empty($firstname) && empty($middlename) && empty($lastname)) {
                    return null;
                }

                $parts = [];
                if (!empty($firstname)) $parts[] = strtoupper($firstname);
                if (!empty($middlename)) $parts[] = strtoupper($middlename);
                if (!empty($lastname)) $parts[] = strtoupper($lastname);

                return implode(' ', $parts);
            };

            // Build parent names (will be null if all fields empty)
            $fathers_name = $buildParentName(
                $request->getPost('fathers_firstname'),
                $request->getPost('fathers_middlename'),
                $request->getPost('fathers_lastname')
            );

            $mothers_name = $buildParentName(
                $request->getPost('mothers_firstname'),
                $request->getPost('mothers_middlename'),
                $request->getPost('mothers_lastname')
            );

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
                'organization_affiliated' => $request->getPost('organization_affiliated'), // Fixed spelling
                'office_address' => $request->getPost('office_address'),
                'contact_person' => $request->getPost('contact_person'),
                'sss_no' => $request->getPost('sss_no'),
                'gsis_no' => $request->getPost('gsis_no'),
                'psn_no' => $request->getPost('psn_no'),
                'philhealth_no' => $request->getPost('philhealth_no'),
            ];

            // Only add fathers_name if not null
            if ($fathers_name !== null) {
                $data['fathers_name'] = $fathers_name;
            }

            // Only add mothers_name if not null
            if ($mothers_name !== null) {
                $data['mothers_name'] = $mothers_name;
            }

            // Remove empty values (optional - only if you want to keep existing data)
            // This prevents overwriting existing data with empty strings
            foreach ($data as $key => $value) {
                if ($value === '' || $value === null) {
                    unset($data[$key]);
                }
            }

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
                    'errors' => $this->validator->getErrors(),
                    'csrf_token' => csrf_hash()
                ]);
            }

            // ✅ COMPARE OLD VS NEW (only for fields that exist in data)
            $changes = [];

            foreach ($data as $field => $newValue) {
                $oldValue = $old[$field] ?? null;

                // Normalize for comparison (handle null vs empty string)
                $oldValueNormalized = ($oldValue === null || $oldValue === '') ? null : (string)$oldValue;
                $newValueNormalized = ($newValue === null || $newValue === '') ? null : (string)$newValue;

                if ($oldValueNormalized !== $newValueNormalized) {
                    // Format the change message nicely
                    $oldDisplay = $oldValueNormalized ?? '[empty]';
                    $newDisplay = $newValueNormalized ?? '[empty]';
                    $changes[] = "$field: {$oldDisplay} → {$newDisplay}";
                }
            }

            // If no changes, return early without updating
            if (empty($changes)) {
                return $this->response->setJSON([
                    'status' => 'info',
                    'message' => 'No changes detected',
                    'changes' => []
                ]);
            }

            // Update record (only if there are changes)
            if (!$model->update($id, $data)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $model->errors(),
                    'csrf_token' => csrf_hash()
                ]);
            }

            // Get updated record for activity log
            $updatedRecord = $model->find($id);

            // ✅ ACTIVITY LOG MESSAGE
            $actionText = 'Updated record (' . implode(', ', $changes) . ')';

            // Load activity log service (check if exists first)
            if (function_exists('service') && method_exists(service('activitylog'), 'save')) {
                service('activitylog')->save([
                    'user_id' => session()->get('userId'),
                    'tag_id' => $updatedRecord['id'],
                    'user_agent' => $request->getUserAgent()->getAgentString(),
                    'ip_address' => $request->getIPAddress(),
                    'action' => $actionText,
                    'tag' => 'MEMBER'
                ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Record updated successfully',
                'changes' => $changes,
                'csrf_token' => csrf_hash()
            ]);
        } catch (\Throwable $e) {
            // Log the error for debugging
            log_message('error', '[updateRecord] Error: ' . $e->getMessage());

            return $this->response->setJSON([
                'status' => 'error',
                'errors' => ['An unexpected error occurred: ' . $e->getMessage()]
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
        $imgUrl = 'uploads/persons/' . $user['id'] . '/' . $newName;
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
            'message' => 'Profile photo updated successfully.',
            'csrf_token' => csrf_hash()
        ]);
    }


    public function printId($id)
    {
        try {
            $model = new PersonsModel();
            $record = $model->select('persons.*, person_disability.disability, cause_of_disability.title, person_occupation.occupation_name')
                ->join('person_disability', 'person_disability.disability_id = persons.type_of_disability')
                ->join('person_occupation', 'person_occupation.occupation_id = persons.occupation')
                ->join('cause_of_disability', 'cause_of_disability.cause_id = persons.cause_of_disability')
                ->where('persons.id', $id)->first();
            // $record = $model->find($id);
            if (!$record) {
                return redirect()->back()->with('error', 'Record not found');
            }

            return view('admin/id-print/id-front', ['record' => $record]);
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function printBack($id)
    {
        try {
            $model = new PersonsModel();
            $person = $model->find($id);

            if (empty($person)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => 'Person record not found.'
                ]);
            }

            return view('admin/id-print/id-back', ['person' => $person]);
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function printLog($id)
    {
        try {
            $model = new PersonsModel();
            $person = $model->where('id', $id)->first();

            if (!$person) {
                return;
            }

            $action = $person['is_printed'] == 0 ? 'Printed ID' : 'Reprinted ID';

            service('activitylog')->save([
                'user_id' => session()->get('userId'),
                'tag_id' => $id,
                'user_agent' => service('request')->getUserAgent()->getAgentString(),
                'ip_address' => service('request')->getIPAddress(),
                'action' => $action,
                'tag' => 'MEMBER'
            ]);

            if ($person['is_printed'] == 0) {
                $model->update($id, ['is_printed' => 1]);
            }
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $e->getMessage()
            ]);
        }
    }
}
