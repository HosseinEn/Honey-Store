<?php

namespace Database\Factories;

use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->text(),
            'total_price' => $this->faker->numberBetween(),
            'price_with_discount' => $this->faker->numberBetween(),
            'invoice_no' => $this->faker->uuid(),
            'transaction_id' => $this->faker->uuid(),
            'reference_id' => '12346',
            'order_status_id' => OrderStatus::all()->random()->id,
            'created_at' => now()->subMonth(random_int(1, 6))->subDay(random_int(1, 28))
        ];
    }
}
