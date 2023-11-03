<?php

namespace Database\Seeders;

use App\Models\SupplierInquiry;
use Illuminate\Database\Seeder;

class SupplierInquirySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SupplierInquiry::factory(5)->create();
    }
}
