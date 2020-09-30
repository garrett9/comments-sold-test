<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->text('description')->nullable();
            $table->text('style')->nullable();
            $table->text('brand')->nullable();
            $table->string('url')->nullable();
            $table->string('product_type')->nullable();
            $table->integer('shipping_price')->unsigned()->nullable();
            $table->text('note')->nullable();
            $table->bigInteger('admin_id')->unsigned();

            $table->foreign('admin_id')->references('id')->on('users')->onDelete('CASCADE');

            $table->timestamps();
        });
    }
}
