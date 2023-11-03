<?php

namespace Database\Factories;

use App\Models\Inquiry;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SupplierInquiry>
 */
class SupplierInquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $inquiry_id = fake()->randomElement(Inquiry::all()->pluck('id'));
        $supplier_id = fake()->randomElement(Supplier::all()->pluck('id'));

        // get a random language from items of inquiry and set it as base inquiry languange
        $item_desc = Inquiry::find($inquiry_id)->items()->pluck('descriptions');

        $lang = fake()->randomElement(fake()->randomElement($item_desc))['lang'];

        return [
            'inquiry_id' => $inquiry_id,
            'supplier_id' => $supplier_id,
            'lang' => $lang,
            'msg_title' => fake()->sentence(3),
            'msg_body' => fake()->text(150),
        ];
    }
}
