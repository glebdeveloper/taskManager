<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePrioritiesTable extends Migration
{
    public function up()
    {
        Schema::create('priorities', function (Blueprint $table) {
            $table->id();
            $table->string('en_title');
            $table->string('ru_title');
            $table->timestamps();
        });

        DB::table('priorities')->insert([
            ['en_title' => 'high', 'ru_title' => 'высокий'],
            ['en_title' => 'average', 'ru_title' => 'средний'],
            ['en_title' => 'low', 'ru_title' => 'низкий']
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('priorities');
    }
}
