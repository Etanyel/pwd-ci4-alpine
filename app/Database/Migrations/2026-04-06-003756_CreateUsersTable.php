<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constant' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'firstname' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'lastname' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'middlename' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'suffix' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'age' => [
                'type' => 'INT',
                'constraint' => 3,
                'null' => false,
            ],
            'sex' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => false,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => false,
            ],
            'img' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true,
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['admin', 'user'],
                'default' => 'user',
                'null' => false,
            ],
            'isActive' => [
                'type'    => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => false,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
