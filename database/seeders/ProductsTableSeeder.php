<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use App\Models\Type;
use App\Models\Attribute;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::factory(5)->make();
        $types = Type::get();
        $attributes = Attribute::get();
        
        foreach ($products as $product) {
            $product->type_id = $types->random(1)->first()->id;
            $product->discount_id = null;
            $product->stock = 0;
            $product->save();
            $product->image()->save(Image::make(['path' => 'seed']));
            $attributesToAttach = $attributes->random(random_int(1, $attributes->count()));
            $totalStock = 0;
            foreach ($attributesToAttach as $attribute) {
                $product->attributes()->attach([
                    $attribute->id => [
                        'stock' => $stock = random_int(1, 1000),
                        'price' => random_int(100000, 1000000)
                    ]
                ]);
                $totalStock += $stock;
            }
            $product->update([
                'stock' => $totalStock
            ]);
        }
    }
}
