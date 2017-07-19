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
            $table->text('job1')->nullable();
            $table->text('job')->nullable();
            $table->text('misc')->nullable();
        });
        DB::table('groups')->insert(array('id' => '3', 'name' => 'Math PhDs', 'route_prefix'=>'MathPhds', 'route_url' => 'math-phds',  'model_name' => 'MathPhd'));
        DB::insert(file_get_contents(base_path().'/phd_backup.sql'));
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
