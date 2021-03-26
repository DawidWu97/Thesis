<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpcomingsTable extends Migration
{
    public function up()
    {
        Schema::create('upcomings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('mileage')->nullable();
            $table->datetime('repair_at');
            $table->longText('description');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
