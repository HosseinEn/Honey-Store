<?php

namespace Database\Seeders;

use App\Models\Carrier;
use Illuminate\Database\Seeder;

class CarrierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carriers = collect([
            ['حمال 1', 10000],
            ['حمال 2', 20000],
            ['حمال 3', 30000]
        ]);

        $carriers->each(function($carrier) {
            Carrier::create([
                'name' => $carrier[0],
                'shipping_price' => $carrier[1]
            ]);
        });
    }
}

