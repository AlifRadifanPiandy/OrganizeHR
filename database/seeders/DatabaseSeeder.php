<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\AdminRole;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'role_name' => 'admin',
        ]);

        Role::create([
            'role_name' => 'pjperusahaan',
        ]);

        Role::create([
            'role_name' => 'pegawai',
        ]);

        AdminRole::create([
            'role_name' => 'superadmin',
        ]);

        AdminRole::create([
            'role_name' => 'admin',
        ]);

        $this->call([
            AdminSeeder::class,
        ]);
    }
}
