<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTodo extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'done' => [
                'type' => 'INT',
                'constraint' => 1,
                'null' => false,
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('todo');
    }

    public function down()
    {
        $this->forge->dropTable('todo');
    }
}
