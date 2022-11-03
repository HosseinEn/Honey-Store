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
            // $table->unsignedBigInteger('carrier_id');
            // $table->foreign('carrier_id')->references('id')->on('carriers');
            // $table->unsignedBigInteger('tax_id');
            // $table->foreign('tax_id')->references('id')->on('taxes');
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->foreign('discount_id')->references('id')->on('discounts');
            $table->date('delivery_date')->nullable();
            $table->bigInteger('total_price');
            // $table->decimal('total_weight');
            $table->string('invoice_no');
            $table->text('shipping_address');
            $table->text('billing_no');
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
