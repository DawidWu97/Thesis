<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUserRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('user_requests', function (Blueprint $table) {
            //$table->unsignedBigInteger('user_id');
            //$table->foreign('user_id', 'user_fk_3432461')->references('id')->on('users');
        });
    }
}
