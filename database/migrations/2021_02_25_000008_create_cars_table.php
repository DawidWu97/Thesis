<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('brand');
            $table->string('model');
            $table->string('engine');
            $table->string('vin');
            $table->string('plates')->unique();
            $table->integer('bought_mileage');
            $table->datetime('bought_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
