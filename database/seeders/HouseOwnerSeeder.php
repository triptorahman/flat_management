<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HouseOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $house_owners = array(
            array('id' => '1', 'name' => 'Test House Owner', 'email' => 'testhouseowner@gmail.com', 'email_verified_at' => NULL, 'password' => '$2y$12$pN/gC1qVIlsUD28JR.Pf7OztpzlgRiQxLR9h0KgK7uLkwT7RSMe8S', 'contact' => '01714491616', 'remember_token' => NULL, 'created_at' => '2025-09-29 08:39:16', 'updated_at' => '2025-09-29 08:39:16'),
            array('id' => '2', 'name' => 'Test House Owner 1', 'email' => 'testhouseowner11@gmail.com', 'email_verified_at' => NULL, 'password' => '$2y$12$pN/gC1qVIlsUD28JR.Pf7OztpzlgRiQxLR9h0KgK7uLkwT7RSMe8S', 'contact' => '01714491616', 'remember_token' => NULL, 'created_at' => '2025-09-29 08:39:16', 'updated_at' => '2025-09-29 08:39:16')

        );

        DB::table('house_owners')->insert($house_owners);

        $buildings = array(
            array('id' => '1', 'house_owner_id' => '1', 'name' => 'Test House Owner Building', 'address' => 'Dhaka Bangladesh', 'created_at' => '2025-09-29 08:39:16', 'updated_at' => '2025-09-29 08:39:16'),
            array('id' => '2', 'house_owner_id' => '2', 'name' => 'Test House Owner 1 Building', 'address' => 'Dhaka Bangladesh', 'created_at' => '2025-09-29 08:39:16', 'updated_at' => '2025-09-29 08:39:16')

        );

        DB::table('buildings')->insert($buildings);
    }
}
