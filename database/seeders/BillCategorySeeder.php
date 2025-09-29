<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bill_categories = array(
            array('id' => '1', 'house_owner_id' => '1', 'name' => 'Utilities', 'created_at' => '2025-09-29 17:05:08', 'updated_at' => '2025-09-29 17:05:08'),
            array('id' => '2', 'house_owner_id' => '1', 'name' => 'Maintenance & Repairs', 'created_at' => '2025-09-29 17:05:33', 'updated_at' => '2025-09-29 17:05:33'),
            array('id' => '3', 'house_owner_id' => '1', 'name' => 'Security Services', 'created_at' => '2025-09-29 17:05:46', 'updated_at' => '2025-09-29 17:05:46'),
            array('id' => '4', 'house_owner_id' => '1', 'name' => 'Insurance & Property Tax', 'created_at' => '2025-09-29 17:05:58', 'updated_at' => '2025-09-29 17:05:58')
        );     

        DB::table('bill_categories')->insert($bill_categories);
    }
}
