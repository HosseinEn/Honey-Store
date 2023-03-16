<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class ProductUserTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();
        $products = \App\Models\Product::get();
        foreach($users as $user) {
            $products = $products->random(5);
            foreach($products as $product) {
                $user->products()->attach($product->id, [
                    'quantity' => rand(1, 5),
                    'attribute_id' => $product->attributes->random()->id
                ]);
            }
        }
    }
}
