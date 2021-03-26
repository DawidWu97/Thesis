<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairsTable extends Migration
{
    public function up()
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('mileage');
            $table->datetime('finished_at')->nullable();
            $table->boolean('approved')->default(0)->nullable();
            $table->longText('description')->nullable();
            $table->longText('customer_comments')->nullable();
            $table->datetime('started_at');
            $table->boolean('canceled')->default(0)->nullable();
            $table->datetime('calculated_finish')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
