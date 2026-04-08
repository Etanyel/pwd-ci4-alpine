<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PersonOccupation extends Seeder
{
    public function run()
    {
        $occupation = [
            'Managers',
            'Professionals',
            'Technical and Associate Professionals',
            'Clerical support workers',
            'Service and Sales workers',
            'Skilled agricultural, forestry and fishery workers',
            'Craft and related trade workers',
            'Plant and machine operators and Assemblers',
            'Elementary occupations',
            'Armed forces occupations',
        ];

        foreach ($occupation as $i) {
            $this->db->table('person_occupation')->insert(['occupation_id' => $i, 'occupation_name' => $i]);
        }
    }
}
