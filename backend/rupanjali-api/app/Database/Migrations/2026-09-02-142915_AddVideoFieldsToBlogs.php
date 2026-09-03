<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVideoFieldsToBlogs extends Migration
{
    public function up()
    {
        $fields = [
            'video_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'featured_image',
            ],
            'video_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'video_type',
            ],
            'video_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
                'after'      => 'video_path',
            ],
        ];

        $this->forge->addColumn('blogs', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('blogs', [
            'video_type',
            'video_path',
            'video_url',
        ]);
    }
}