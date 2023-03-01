<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('en_title');
            $table->string('ru_title');
            $table->timestamps();
        });

        DB::table('statuses')->insert([
            ['en_title' => 'to be done', 'ru_title' => 'к выполнению'],
            ['en_title' => 'in progress', 'ru_title' => 'выполняется'],
            ['en_title' => 'done', 'ru_title' => 'выполнена'],
            ['en_title' => 'canceled', 'ru_title' => 'отменена']
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('statuses');
    }
}