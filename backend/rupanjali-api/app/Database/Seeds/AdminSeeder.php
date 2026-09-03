<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('admins')->insert([
            'name' => 'Rupanjali Admin',
            'email' => 'admin@rupanjali.com',
            'password' => password_hash('Admin@123', PASSWORD_DEFAULT),
        ]);
    }
}
