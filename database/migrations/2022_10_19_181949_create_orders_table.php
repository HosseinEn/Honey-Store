<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('order_status_id');
            $table->foreign('order_status_id')->references('id')->on('order_statuses');
            $table->string('description')->nullable();
            $table->date('delivery_date')->nullable();
            $table->bigInteger('total_price');
            $table->unsignedBigInteger('discount_id')->nullable();
            // $table->decimal('total_weight');
            $table->string('invoice_no');
            $table->text('shipping_address');
            $table->text('transaction_id');
            $table->text('reference_id')->nullable();
            // city_id or province_id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
