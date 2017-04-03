<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
        });

        DB::table('groups')->insert(
            array(
                'id' => '1',
                'name' => 'Super User',
            )
        );

        DB::table('groups')->insert(
            array(
                'id' => '2',
                'name' => 'Funding Opportunities',
            )
        );

        DB::table('groups')->insert(
            array(
                'id' => '3',
                'name' => 'Math PhDs',
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
        Schema::dropIfExists('groups');
    }
}

