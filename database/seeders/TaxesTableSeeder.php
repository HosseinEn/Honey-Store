<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Seeder;

class TaxesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taxes = collect([
            [
                'name' => 'دولت',
                'value' => '0.09'
            ]
        ]);

        $taxes->each(function($tax) {
            Tax::create([
                'name' => $tax['name'],
                'value' => $tax['value']
            ]);
        });
    }
}
