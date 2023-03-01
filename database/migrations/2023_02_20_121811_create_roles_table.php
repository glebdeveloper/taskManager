<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('en_title');
            $table->string('ru_title');
            $table->timestamps();
        });

        DB::table('roles')->insert([
            ['en_title' => 'boss', 'ru_title' => 'руководитель'],
            ['en_title' => 'subordinate', 'ru_title' => 'пользователь'],
            ['en_title' => 'root', 'ru_title' => 'рут']
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
