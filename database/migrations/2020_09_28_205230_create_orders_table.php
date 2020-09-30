<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('inventory_id')->unsigned();
            $table->text('street_address')->nullable();
            $table->text('apartment')->nullable();
            $table->text('city')->nullable();
            $table->text('state')->nullable();
            $table->string('country_code')->nullable();
            $table->text('zip')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('email');
            $table->string('name');
            $table->string('order_status');
            $table->text('payment_ref')->nullable();
            $table->string('transaction_id')->nullable();
            $table->integer('payment_amt_cents')->unsigned();
            $table->integer('ship_charged_cents')->unsigned()->nullable();
            $table->integer('ship_cost_cents')->unsigned()->nullable();
            $table->integer('subtotal_cents')->unsigned();
            $table->integer('total_cents')->unsigned();
            $table->text('shipper_name');
            $table->dateTime('payment_date');
            $table->dateTime('shipped_date');
            $table->text('tracking_number');
            $table->integer('tax_total_cents')->unsigned();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('CASCADE');
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('CASCADE');
            $table->timestamps();
        });
    }
}
