<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->boolean('enabled')->default(false);
        });

        DB::table('users')->insert(
            array(
                'id' => 1,
                'email' => 'admin@admin.com',  //fix this... later//
                'enabled' => true,
                'name' => 'admin',
                'password' => '$2y$10$OSwT0FOe6/Sc9MQDZJdmC.IeB4p/2ttLw3Qa/PZQWmpxIAIc8B2bi'  //Default password is admin
            )
        );
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

