<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributes = collect([1, 2, 5, 10, 15]);

        $attributes->each(function($type) {
            Attribute::create([
                "weight" => $type,
            ]);
        });
    }
}
