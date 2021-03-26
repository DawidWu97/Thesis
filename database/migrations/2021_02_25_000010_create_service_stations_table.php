<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceStationsTable extends Migration
{
    public function up()
    {
        Schema::create('service_stations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('city');
            $table->string('street');
            $table->string('postcode');
            $table->boolean('approved')->default(0)->nullable();
            $table->longText('description')->nullable();
            $table->time('opening');
            $table->time('closing');
            $table->integer('workplaces');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
