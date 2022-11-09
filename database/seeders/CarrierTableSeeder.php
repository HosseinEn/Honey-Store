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
            ['پست معمولی', 10000],
            ['پست پیشتاز', 20000],
            ['پست فوری', 30000]
        ]);

        $carriers->each(function($carrier) {
            Carrier::create([
                'name' => $carrier[0],
                'shipping_price' => $carrier[1]
            ]);
        });
    }
}

