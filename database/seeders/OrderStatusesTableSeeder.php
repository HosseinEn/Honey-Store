<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = collect([
            [
                'name' => 'تایید شده'
            ],
            [
                'name' => 'لغو شده'
            ],
            [
                'name' => 'نیاز به استرداد وجه'
            ],
            [
                'name' => 'استرداد وجه انجام شده'
            ],
            [
                'name' => 'پرداخت نشده'
            ]
        ]);

        $statuses->each(function($status) {
            OrderStatus::create([
                'name' => $status['name']
            ]);
        });
    }
}
