<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\TypeTableSeeder;
use Database\Seeders\AttributeTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            TypeTableSeeder::class,
            AttributeTableSeeder::class,
        ]);
    }
}
