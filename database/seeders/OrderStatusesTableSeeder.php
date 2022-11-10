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
                'name' => 'در انتظار تایید اپراتور',
            ],
            [
                'name' => 'تایید شده'
            ],
            [
                'name' => 'بسته بندی شده'
            ],
            [
                'name' => 'آماده ارسال'
            ],
            [
                'name' => 'ارسال شده'
            ],
            [
                'name' => 'لغو شده'
            ],
            [
                'name' => 'درخواست لغو'
            ]
        ]);

        $statuses->each(function($status) {
            OrderStatus::create([
                'name' => $status['name']
            ]);
        });
    }
}
