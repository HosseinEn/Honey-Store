<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributes = collect([["small", 1], ["small", 2], ["medium", 5], ["big", 10], ["big", 15]]);

        $attributes->each(function($type) {
            Attribute::create([
                "size" => $type[0],
                "weight" => $type[1],
            ]);
        });
    }
}
