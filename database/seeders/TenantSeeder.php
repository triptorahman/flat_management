<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenants = array(
            array('id' => '2', 'name' => 'test tenant', 'email' => 'test@gmail.com', 'contact' => '017144916166', 'building_id' => '1', 'flat_id' => '1', 'assigned_by_admin_id' => '1', 'created_at' => '2025-09-29 16:33:20', 'updated_at' => '2025-09-29 16:33:20')
        );
        DB::table('tenants')->insert($tenants);
    }
}
