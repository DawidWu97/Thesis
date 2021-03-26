<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUpcomingsTable extends Migration
{
    public function up()
    {
        Schema::table('upcomings', function (Blueprint $table) {
            $table->unsignedBigInteger('car_id');
            $table->foreign('car_id', 'car_fk_3276002')->references('id')->on('cars');
        });
    }
}
