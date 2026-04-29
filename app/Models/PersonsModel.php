<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonsModel extends Model
{
    protected $table            = 'persons';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pwd_no',
        'lastname',
        'firstname',
        'middlename',
        'suffix',
        'sex',
        'age',
        'street_name',
        'barangay',
        'city_municipality',
        'province',
        'region',
        'birthdate',
        'mobile_no',
        'email',
        'landline',
        'type_of_disability',
        'cause_of_disability',
        'cause_of',
        'other_cause',
        'civil_status',
        'employment_status',
        'educational_attainment',
        'category_of_employment',
        'nature_of_employment',
        'occupation',
        'other_occupation',
        'bloodtype',
        'organization_affliated',
        'office_address',
        'contact_person',
        'sss_no',
        'gsis_no',
        'psn_no',
        'philhealth_no',
        'fathers_name',
        'mothers_name',
        'date_applied',
        'img',
        'is_printed'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
