<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('description');
            $table->date('must_ended_at');
            $table->unsignedBigInteger('priority_id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('responsible_id');
            $table->unsignedBigInteger('mode_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}