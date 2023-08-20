<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'nama' => 'superadmin',
            'email' => 'billy@gmail.com',
            'password' => bcrypt('Billy123'),
            'role_admin' => 1,
            'id_role' => 1,
        ]);
    }
}
