<?php
/**
 * This file contains the routes for the APIs that are to be made public.  It is put in its own file so that the
 * php artisan command for generating a new application can be done in an automated and safe manner.*/
#FundingOpportunity APIs

Route::get('fund-opp', ['uses'=>'FundingOpportunityController@publicIndex', 'model' => new \App\FundingOpportunity()]);

Route::get('funding-opportunities/', 'FundingOpportunityController@publicIndex', ['model' => new \App\FundingOpportunity()]);
Route::get('math-phds/', 'FundingOpportunityController@publicIndex');

