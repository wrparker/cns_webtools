<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundingOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funding_opportunities', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->dateTime('announced');
            $table->dateTime('sponsor_deadline');
            $table->dateTime('internal_deadline');
            $table->text('link');

            $table->boolean('visible');
            $table->boolean('limited_submission'); #yes/no
            $table->boolean('status'); #true = open, false = closed/recurring.

            #FKs
            $table->integer('type');
            $table->integer('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funding_opportunities');
    }
}
