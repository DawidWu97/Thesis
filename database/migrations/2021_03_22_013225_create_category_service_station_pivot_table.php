<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryServiceStationPivotTable extends Migration
{
    public function up()
    {
        Schema::create('category_service_station', function (Blueprint $table) {
            $table->unsignedBigInteger('service_station_id');
            $table->foreign('service_station_id', 'service_station_id_fk_3492829')->references('id')->on('service_stations')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id', 'category_id_fk_3492829')->references('id')->on('categories')->onDelete('cascade');
        });
    }
}
