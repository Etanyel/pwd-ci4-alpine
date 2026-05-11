<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PersonsModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Exports extends BaseController
{
    public function exportRecords()
    {
        $employment_status = [
            0 => 'Employed',
            1 => 'Unemployed',
            2 => 'Self-Employed',
        ];

        $category_employment = [
            0 => 'Government',
            1 => 'Private'
        ];

        $nature_of_employment = [
            0 => 'Permanent/Regular',
            1 => 'Casual',
            2 => 'Seasonal',
            3 => 'Emergency',
        ];

        $model = new PersonsModel();
        $data = $model->select('persons.*, person_disability.disability, cause_of_disability.title, person_occupation.occupation_name, civil_status.status_name, educational_attainment.education')
            ->join('person_disability', 'person_disability.disability_id = persons.type_of_disability')
            ->join('person_occupation', 'person_occupation.occupation_id = persons.occupation')
            ->join('civil_status', 'civil_status.id = persons.civil_status')
            ->join('educational_attainment', 'educational_attainment.id = persons.educational_attainment')
            ->join('cause_of_disability', 'cause_of_disability.cause_id = persons.cause_of_disability')->orderBy('persons.lastname', 'ASC')->findAll();

        $headers = [
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
            'disability',
            'title',
            'other_cause',
            'status_name',
            'employment_status',
            'education',
            'category_of_employment',
            'nature_of_employment',
            'occupation_name',
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
        ];

        $excelHeader = [
            'PWD NO.',
            'LASTNAME',
            'FIRSTNAME',
            'MIDDLENAME',
            'SUFFIX',
            'SEX',
            'AGE',
            'STREET NAME',
            'BARANGAY',
            'CITY MUNICIPALITY',
            'PROVINCE',
            'REGION',
            'BIRTHDATE',
            'MOBILE NO.',
            'EMAIL',
            'LANDLINE',
            'TYPE OF DISABILITY',
            'CAUSE OF DISABILITY',
            'OTHER CAUSE',
            'CIVIL STATUS',
            'EMPLOYMENT STATUS',
            'EDUCATIONAL ATTAINMENT',
            'CATEGORY OF EMPLOYMENT',
            'NATURE OF EMPLOYMENT',
            'OCCUPATION',
            'OTHER OCCUPATION',
            'BLOOD TYPE',
            'ORGANIZATION AFFLIATED',
            'OFFICE ADDRESS',
            'CONTACT PERSON',
            'SSS NO.',
            'GSIS NO.',
            'PSN NO.',
            'PHILHEALTH',
            'FATHERS NAME',
            'MOTHERS NAME',
            'DATE APPLIED',
        ];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header row
        $col = 'A';

        foreach ($excelHeader as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        $sheet->getStyle('A1:AK1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => '000000'
                ]
            ],

            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'C6EFCE'
                ]
            ],

            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ]
        ]);

        // Data rows
        $row = 2;

        foreach ($data as $item) {
            $col = 'A';

            foreach ($headers as $field) {

                $value = $item[$field] ?? '';

                if ($field == 'employment_status') {
                    $value = $employment_status[$value] ?? '';
                }

                if ($field == 'category_of_employment') {
                    $value = $category_employment[$value] ?? '';
                }

                if ($field == 'nature_of_employment') {
                    $value = $nature_of_employment[$value] ?? '';
                }

                $value = strtoupper((string)$value);

                $sheet->setCellValue($col . $row, $value);

                $col++;
            }

            $row++;
        }

        $filename = 'pwd_list.xlsx';

        $temp_file = tempnam(sys_get_temp_dir(), 'xlsx');

        $writer = new Xlsx($spreadsheet);
        $writer->save($temp_file);

        return $this->response->download($temp_file, null)
            ->setFileName($filename);

        // $writer->save('php://output');
        // exit;
    }


    public function exportRecordsByMonth($date = null)
    {
        [$year, $month] = explode('-', $date);

        $employment_status = [
            0 => 'Employed',
            1 => 'Unemployed',
            2 => 'Self-Employed',
        ];

        $category_employment = [
            0 => 'Government',
            1 => 'Private'
        ];

        $nature_of_employment = [
            0 => 'Permanent/Regular',
            1 => 'Casual',
            2 => 'Seasonal',
            3 => 'Emergency',
        ];

        $model = new PersonsModel();
        $data = $model->select('persons.*, person_disability.disability, cause_of_disability.title, person_occupation.occupation_name, civil_status.status_name, educational_attainment.education')
            ->join('person_disability', 'person_disability.disability_id = persons.type_of_disability')
            ->join('person_occupation', 'person_occupation.occupation_id = persons.occupation')
            ->join('civil_status', 'civil_status.id = persons.civil_status')
            ->join('educational_attainment', 'educational_attainment.id = persons.educational_attainment')
            ->join('cause_of_disability', 'cause_of_disability.cause_id = persons.cause_of_disability')->orderBy('persons.lastname', 'ASC')->where('YEAR(persons.created_at)', $year)->where('MONTH(persons.created_at)', $month)->findAll();

        $headers = [
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
            'disability',
            'title',
            'other_cause',
            'status_name',
            'employment_status',
            'education',
            'category_of_employment',
            'nature_of_employment',
            'occupation_name',
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
        ];

        $excelHeader = [
            'PWD NO.',
            'LASTNAME',
            'FIRSTNAME',
            'MIDDLENAME',
            'SUFFIX',
            'SEX',
            'AGE',
            'STREET NAME',
            'BARANGAY',
            'CITY MUNICIPALITY',
            'PROVINCE',
            'REGION',
            'BIRTHDATE',
            'MOBILE NO.',
            'EMAIL',
            'LANDLINE',
            'TYPE OF DISABILITY',
            'CAUSE OF DISABILITY',
            'OTHER CAUSE',
            'CIVIL STATUS',
            'EMPLOYMENT STATUS',
            'EDUCATIONAL ATTAINMENT',
            'CATEGORY OF EMPLOYMENT',
            'NATURE OF EMPLOYMENT',
            'OCCUPATION',
            'OTHER OCCUPATION',
            'BLOOD TYPE',
            'ORGANIZATION AFFLIATED',
            'OFFICE ADDRESS',
            'CONTACT PERSON',
            'SSS NO.',
            'GSIS NO.',
            'PSN NO.',
            'PHILHEALTH',
            'FATHERS NAME',
            'MOTHERS NAME',
            'DATE APPLIED',
        ];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header row
        $col = 'A';

        foreach ($excelHeader as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        $sheet->getStyle('A1:AK1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => '000000'
                ]
            ],

            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'C6EFCE'
                ]
            ],

            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ]
        ]);

        // Data rows
        $row = 2;

        foreach ($data as $item) {
            $col = 'A';

            foreach ($headers as $field) {

                $value = $item[$field] ?? '';

                if ($field == 'employment_status') {
                    $value = $employment_status[$value] ?? '';
                }

                if ($field == 'category_of_employment') {
                    $value = $category_employment[$value] ?? '';
                }

                if ($field == 'nature_of_employment') {
                    $value = $nature_of_employment[$value] ?? '';
                }

                $value = strtoupper((string)$value);

                $sheet->setCellValue($col . $row, $value);

                $col++;
            }

            $row++;
        }

        $filename = 'PWD_LIST_MONTH_OF_' . strtoupper(date('F', strtotime($month))) . ' - ' . $year . '.xlsx';

        $temp_file = tempnam(sys_get_temp_dir(), 'xlsx');

        $writer = new Xlsx($spreadsheet);
        $writer->save($temp_file);

        return $this->response->download($temp_file, null)
            ->setFileName($filename);

        // $writer->save('php://output');
        // exit;
    }
}
