<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CauseOfDisability extends Seeder
{
    public function run()
    {
        $inborn = [
            'Autism',
            'ADHD',
            'Cerebral Palsy',
            'Down Syndrome',
        ];

        $acquired = [
            'Chronic Illness',
            'Cerebral Palsy',
            'Injury',
        ];

        foreach ($inborn as $i) {
            $this->db->table('cause_of_disability')->insert(['cause' => 0, 'title' => $i]);
        }

        foreach ($acquired as $a) {
            $this->db->table('cause_of_disability')->insert(['cause' => 1, 'title' => $a]);
        }
    }
}
