<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();
        foreach($users as $user) {
            $user->orders()->saveMany(\App\Models\Order::factory(10)->make());
        }
    }
}
