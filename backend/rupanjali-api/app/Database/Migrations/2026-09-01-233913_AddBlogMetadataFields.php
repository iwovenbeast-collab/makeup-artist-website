<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBlogMetadataFields extends Migration
{
    public function up()
    {
        $fields = [
            'category' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'slug',
            ],

            'excerpt' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'category',
            ],

            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'published',
                'after'      => 'featured_image',
            ],

            'published_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'after'   => 'status',
            ],
        ];

        $this->forge->addColumn('blogs', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('blogs', [
            'category',
            'excerpt',
            'status',
            'published_at',
        ]);
    }
}
