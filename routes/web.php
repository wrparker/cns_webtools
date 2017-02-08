<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('FundingOpportunityType/create/', function(){

    return view('FundingOpportunities.createType');
});

/*Route::post('/create/FundingOpportunityType', function(){
   return "success";
});*/

#Use CRUD URLs
Route::group(['prefix' => 'FundingOpportunities'], function() {
    Route::resource('types', 'FundingOpportunityTypeController', ['names' => [
        'index' => 'FundingOpportunityTypes.index',
        'create' => 'FundingOpportunityTypes.create',
        'store' => 'FundingOpportunityTypes.store',
        'show' => 'FundingOpportunityTypes.show',
        'edit' => 'FundingOpportunityTypes.edit',
        'update' => 'FundingOpportunityTypes.update',
        'destroy' => 'FundingOpportunityTypes.destroy'
    ]]);
});

Route::get('/test', function(){
   return \App\FundingOpportunityType::getDropdownHTMLList();
});


