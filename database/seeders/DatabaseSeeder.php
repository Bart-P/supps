<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Bartek',
            'email' => 'bartek@mephistomedia.com',
        ]);

        $this->call([
            CategorySeeder::class,
            # ProductSeeder has to come after CategorySeeder
            ProductSeeder::class,
            PrintTypeSeeder::class,
            TagSeeder::class,
            # call SupplierSeeder after print, tag and category because it depends on them
            SupplierSeeder::class,
            # call Address and Person Seeder after Supplier, both need a supplier_id
            AddressSeeder::class,
            PersonSeeder::class,
            ProjectSeeder::class,
            # Items will be created within InquirySeeder
            # Inquiries (and Items) have to be created after Projects
            InquirySeeder::class,

            SupplierInquirySeeder::class,
        ]);
    }
}
