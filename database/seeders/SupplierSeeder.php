<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = Supplier::factory(100)->create();

        $suppliers->each(function ($supp) {
            $cat = Category::all('id')->random(1);
            $tag = Tag::all('id')->random(1);
            $products = Product::all('id')->random(random_int(1, 4));
            $supp->categories()->attach($cat->values()[0]->id);
            $supp->tags()->attach($tag->values()[0]->id);

            $products->each(function ($product) use ($supp) {
                $supp->products()->attach($product->id);
            });
        });

        $cardboardSuppliers = Category::find(1)->suppliers();
        $cardboardSuppliers->each(function ($supp) {
            $supp->print_types()->attach(fake()->randomElements([1, 2, 3, 4, 5, 6, 7], random_int(1, 4)));
        });

        $printSuppliers = Category::find(9)->suppliers();
        $printSuppliers->each(function ($supp) {
            $supp->print_types()->attach(fake()->randomElements([1, 2, 3, 4, 5, 6, 7], random_int(1, 7)));
        });
    }
}
