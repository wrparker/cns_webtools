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
            $table->text('name');
            $table->timestamps();
            $table->text('announced');
            $table->text('agency');
            $table->text('sponsor_deadline');
            $table->text('internal_deadline');
            $table->text('link_internal')->nullable();
            $table->text('link_external')->nullable();

            $table->boolean('visible');
            $table->boolean('limited_submission'); #yes/no
            $table->boolean('status'); #true = open, false = closed/recurring.
            $table->text('funding_type');
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
