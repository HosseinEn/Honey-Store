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
            ['dis1', 10],
            ['dis2', 20],
            ['dis3', 30]
        ]);

        $discounts->each(function($discount) {
            Discount::create([
                'name' => $discount[0],
                'value' => $discount[1]
            ]);
        });
    }
}
