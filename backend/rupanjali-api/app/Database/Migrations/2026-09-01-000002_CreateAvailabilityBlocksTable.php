<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAvailabilityBlocksTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'block_date' => [
                'type' => 'DATE',
            ],

            'start_time' => [
                'type' => 'TIME',
                'null' => true,
            ],

            'end_time' => [
                'type' => 'TIME',
                'null' => true,
            ],

            'all_day' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],

            'reason' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('block_date');

        $this->forge->createTable('availability_blocks');
    }

    public function down()
    {
        $this->forge->dropTable('availability_blocks');
    }
}
