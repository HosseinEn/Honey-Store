<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Seeder;

class DiscountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $discounts = collect([
            ['تخفیف 1', 5],
            ['تخفیف 2', 10],
            ['تخفیف 3', 15]
        ]);

        $discounts->each(function($discount) {
            Discount::create([
                'name' => $discount[0],
                'value' => $discount[1]
            ]);
        });
    }
}
