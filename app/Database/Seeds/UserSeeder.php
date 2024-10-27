<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data=array(
            'name'=>'Admin',
            'email'=>'admin@login.com',
            'username'=>'admin',
            'password'=>password_hash('Bad2@',PASSWORD_BCRYPT),
        );

        $this->db->table('users')->insert($data);
    }
}
