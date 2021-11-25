<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBestProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('best_product', function (Blueprint $table) {
            $table->string('product_id');
            $table->string('best_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('best_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('best_product');
    }
}
