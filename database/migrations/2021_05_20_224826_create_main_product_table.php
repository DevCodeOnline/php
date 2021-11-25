<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_product', function (Blueprint $table) {
            $table->increments('id');
            $table->string('best_product_id');
            $table->string('new_product_id');
            $table->foreign('best_product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('new_product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_product');
    }
}
