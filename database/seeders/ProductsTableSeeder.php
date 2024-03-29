<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use App\Models\Type;
use App\Models\Attribute;
use App\Models\Discount;
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
        $products = Product::factory(50)->make();
        $types = Type::get();
        $discounts = Discount::get()->pluck('id');
        $discounts->push(Null);

        $attributes = Attribute::get();
        
        foreach ($products as $product) {
            $product->type_id = $types->random(1)->first()->id;
            $product->stock = 0;
            $product->save();
            $product->image()->save(Image::make(['path' => 'seed']));
            $attributesToAttach = $attributes->random(random_int(1, $attributes->count()));
            $totalStock = 0;
            foreach ($attributesToAttach as $attribute) {
                $product->attributes()->attach([
                    $attribute->id => [
                        'stock' => $stock = random_int(10, 1000),
                        'price' => random_int(100000, 1000000),
                        'discount_id' => $discounts->random()
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
