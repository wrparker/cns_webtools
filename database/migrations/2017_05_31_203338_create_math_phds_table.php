<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMathPhdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('math_phds', function (Blueprint $table) {
            $table->increments('id');
            $table->text('lastname');
            $table->text('firstname');
            $table->text('advisors');
            $table->text('degree');
            $table->text('year');
            $table->text('dissertation');
            $table->text('job1');
            $table->text('job');
            $table->text('misc');
        });

        DB::table('groups')->insert(array('id' => '3', 'name' => 'Math PhDs', 'route_prefix'=> 'MathPhds'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('math_phds');
        App\Group::destroy(3);
    }
}
