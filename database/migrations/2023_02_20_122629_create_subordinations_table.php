<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubordinationsTable extends Migration
{
    public function up()
    {
        Schema::create('subordinations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subordinate_id')->unique();
            $table->unsignedBigInteger('boss_id');
            $table->timestamps();

            $table->foreign('subordinate_id')->references('id')->on('users');
            $table->foreign('boss_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subordinations');
    }
}