<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class AddRecord extends Seeder
{
    public function run()
    {
        $faker = Factory::create('en_PH');

        // Optional: clear table first
        $this->db->table('persons')->truncate();

        $barangays = [
            'CAWA-CAWA (POB.)',
            'OWAON',
            'POTOL',
            'TAGUILON',
            'BAYLIMANGO',
            'SAN VICENTE',
            'ILAYA',
            'TINIGAWAN',
        ];

        $data = [];

        for ($i = 1; $i <= 300; $i++) {

            $sex = $faker->randomElement(['male', 'female']);

            $data[] = [

                'pwd_no' => sprintf(
                    '%02d-%04d-%03d-%08d',
                    rand(1, 99),
                    rand(1000, 9999),
                    rand(100, 999),
                    rand(10000000, 99999999)
                ),

                'lastname' => strtoupper($faker->lastName()),

                'firstname' => strtoupper(
                    $sex == 'male'
                        ? $faker->firstNameMale()
                        : $faker->firstNameFemale()
                ),

                'middlename' => strtoupper($faker->lastName()),

                'suffix' => '',

                'sex' => $sex,

                'age' => rand(1, 100),

                'street_name' => strtoupper(
                    'PUROK ' . $faker->randomElement([
                        'MALIPAYON',
                        'MANUMBAG',
                        'MASINADYAHON',
                        'MAKUGIHON',
                        'PAGLAUM',
                        'KALINAW',
                    ])
                ),

                'barangay' => $faker->randomElement($barangays),

                'city_municipality' => 'CITY OF DAPITAN',

                'province' => 'ZAMBOANGA DEL NORTE',

                'region' => 'REGION IX',

                'birthdate' => $faker->date('Y-m-d', '-1 years'),

                'mobile_no' => '09' . rand(100000000, 999999999),

                'email' => '',

                'landline' => '',

                // Integer values based on your schema
                'type_of_disability' => rand(1, 7),

                'cause_of_disability' => rand(1, 5),

                'cause_of' => rand(1, 3),

                'other_cause' => 'undefined',

                'civil_status' => rand(0, 4),

                'employment_status' => rand(0, 5),

                'educational_attainment' => rand(0, 10),

                'category_of_employment' => rand(0, 5),

                'nature_of_employment' => rand(0, 5),

                'occupation' => rand(0, 15),

                'other_occupation' => '',

                'bloodtype' => $faker->randomElement([
                    'A+',
                    'A-',
                    'B+',
                    'B-',
                    'O+',
                    'O-',
                    'AB+',
                    'AB-'
                ]),

                'organization_affliated' => 'None',

                'office_address' => 'None',

                'contact_person' => 'None',

                'sss_no' => '',

                'gsis_no' => '',

                'psn_no' => '',

                'philhealth_no' => '',

                'fathers_name' => null,

                'mothers_name' => null,

                'date_applied' => $faker->date('Y-m-d'),

                'img' => null,

                'created_at' => date('Y-m-d H:i:s'),

                'updated_at' => null,

                'is_printed' => 0,
            ];
        }

        $this->db->table('persons')->insertBatch($data);
    }
}
