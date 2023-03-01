<?php
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;
class CreateUsersTable extends Migration
{
    public function up()
    {
        $faker = Faker::create('ru_RU');
        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) use ($faker) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name');
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedBigInteger('role_id');
            $table->rememberToken();
            $table->timestamps();
        });
        for ($i = 0; $i < 20; $i++) {
                $email = $faker->unique()->safeEmail;
                $password = $faker->password;
                DB::table('users')->insert([
                    'name' => $faker->userName,
                    'email' => $email,
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'middle_name' => $faker->middleName,
                    'password' => bcrypt($password),
                    'role_id' => 1,
                ]);
                Storage::append('logins.txt', $email . ':' . $password);
        }
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
