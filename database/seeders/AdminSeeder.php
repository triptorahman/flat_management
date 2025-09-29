<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = array(
            array('id' => '1', 'name' => 'Test Admin', 'email' => 'admin@gmail.com', 'email_verified_at' => NULL, 'password' => '$2y$12$pN/gC1qVIlsUD28JR.Pf7OztpzlgRiQxLR9h0KgK7uLkwT7RSMe8S', 'remember_token' => NULL, 'created_at' => '2025-09-28 18:04:37', 'updated_at' => '2025-09-28 18:04:37'),
            array('id' => '2', 'name' => 'Test Admin 2', 'email' => 'admin2@gmail.com', 'email_verified_at' => NULL, 'password' => '$2y$12$pN/gC1qVIlsUD28JR.Pf7OztpzlgRiQxLR9h0KgK7uLkwT7RSMe8S', 'remember_token' => NULL, 'created_at' => '2025-09-29 05:23:05', 'updated_at' => '2025-09-29 05:23:05')
        );
        DB::table('users')->insert($users);
    }
}
