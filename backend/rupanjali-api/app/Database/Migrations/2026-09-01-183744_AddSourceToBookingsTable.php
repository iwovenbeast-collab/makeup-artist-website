<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSourceToBookingsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('bookings', [
            'source' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
                'after'      => 'status',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('bookings', 'source');
    }
}