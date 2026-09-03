<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBookingTimes extends Migration
{
    public function up()
    {
        $this->forge->addColumn('bookings', [
            'start_time' => [
                'type' => 'TIME',
                'null' => true,
                'after' => 'event_date',
            ],
            'end_time' => [
                'type' => 'TIME',
                'null' => true,
                'after' => 'start_time',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('bookings', [
            'start_time',
            'end_time',
        ]);
    }
}
