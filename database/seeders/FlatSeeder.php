<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flats = array(
            array('id' => '1', 'building_id' => '1', 'house_owner_id' => '1', 'flat_number' => 'Test Flat 1', 'owner_name' => 'test', 'owner_contact' => '01714491616', 'owner_email' => 'testflat@gmail.com', 'available' => 'no', 'created_at' => '2025-09-29 16:05:20', 'updated_at' => '2025-09-29 16:33:20')
        );
        // Insert the data into the 'flats' table
        DB::table('flats')->insert($flats);
    }
}
