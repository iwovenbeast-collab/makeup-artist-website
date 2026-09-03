<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePortfolioItemsTable extends Migration
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
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'category' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => 'Bridal',
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default'    => 'active',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('portfolio_items');
    }

    public function down()
    {
        $this->forge->dropTable('portfolio_items');
    }
}