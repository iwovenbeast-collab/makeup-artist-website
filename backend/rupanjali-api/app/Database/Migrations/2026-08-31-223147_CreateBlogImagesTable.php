<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBlogImagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'blog_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],

            'image_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('blog_id');

        $this->forge->addForeignKey(
            'blog_id',
            'blogs',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('blog_images');
    }

    public function down()
    {
        $this->forge->dropTable('blog_images');
    }
}
