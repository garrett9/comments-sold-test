<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->text('color')->nullable();
            $table->text('size')->nullable();
            $table->float('weight')->unsigned()->nullable();
            $table->integer('price_cents')->unsigned();
            $table->integer('sale_price_cents')->unsigned();
            $table->integer('cost_cents')->unsigned();
            $table->string('sku');
            $table->float('length')->unsigned()->nullable();
            $table->float('width')->unsinged()->nullable();
            $table->float('height')->unsinged()->nullable();
            $table->text('note')->nullable();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('CASCADE');
            $table->timestamps();
        });
    }
}
