<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_region', function (Blueprint $table) {
            $table->unsignedInteger('delivery_id');
            $table->unsignedInteger('region_id');
            $table->tinyInteger('days')->nullable();
            $table->float('value')->unsigned()->nullable();
            $table->float('percent')->unsigned()->nullable();
            $table->tinyInteger('status')->default(1);
            $table->foreign('delivery_id')->references('id')->on('deliveries')->onDelete('cascade');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_region');
    }
}
