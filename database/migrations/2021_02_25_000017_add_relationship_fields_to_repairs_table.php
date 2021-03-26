<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToRepairsTable extends Migration
{
    public function up()
    {
        Schema::table('repairs', function (Blueprint $table) {
            $table->unsignedBigInteger('car_id');
            $table->foreign('car_id', 'car_fk_3275136')->references('id')->on('cars');
            $table->unsignedBigInteger('station_id');
            $table->foreign('station_id', 'station_fk_3275137')->references('id')->on('service_stations');
        });
    }
}
