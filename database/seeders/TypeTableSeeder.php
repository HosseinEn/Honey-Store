<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = collect(["noe-1", "noe-2", "noe-3", "noe-4"]);

        $types->each(function($type) {
            Type::create([
                "name" => $type,
                "slug" => Str::slug($type)
            ]);
        });
    }
}
