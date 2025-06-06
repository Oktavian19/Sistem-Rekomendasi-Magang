<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $admins = [
            ['username' => 'admin01', 'nama' => 'Admin Satu',   'email' => 'admin01@example.com'],
            ['username' => 'admin02', 'nama' => 'Admin Dua',    'email' => 'admin02@example.com'],
            ['username' => 'admin03', 'nama' => 'Admin Tiga',   'email' => 'admin02@example.com'],
        ];

        foreach ($admins as $admin) {
            DB::table('users')->insert([
            [
                'username'  => $admin['username'],
                'password'  => Hash::make('admin123'),
                'role'      => 'admin',
                'status'    => 'aktif',
                'created_at' => now(),
            ]]);

            $id = DB::table('users')->where('username', $admin['username'])->value('id_user');

            DB::table('admin')->insert([
                'id_admin' => $id,
                'nama' => $admin['nama'],
                'email' => $admin['email'],
                'no_hp' => '08123456789',
                'created_at' => now(),
            ]);
        }
    }
}
