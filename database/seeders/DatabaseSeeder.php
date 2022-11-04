<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\TypesTableSeeder;
use Database\Seeders\CarrierTableSeeder;
use Database\Seeders\AttributesTableSeeder;
use Database\Seeders\OrderStatusesTableSeeder;

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
            DiscountsTableSeeder::class,
            TaxesTableSeeder::class,
            OrderStatusesTableSeeder::class,
            ProductsTableSeeder::class,
            CarrierTableSeeder::class
        ]);
    }
}
