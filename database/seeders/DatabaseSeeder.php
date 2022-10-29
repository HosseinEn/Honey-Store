<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\TypesTableSeeder;
use Database\Seeders\AttributesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->createAdmin()->create();
        $this->call([
            TypesTableSeeder::class,
            AttributesTableSeeder::class,
            DiscountsTableSeeder::class
        ]);
    }
}
