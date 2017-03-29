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
    if(Auth::check()){
        return view('home');
    }
    else{
        return view('auth.login');
    }
});


Route::get('FundingOpportunityType/create/', function(){

    return view('FundingOpportunities.createType');
});

/*Route::post('/create/FundingOpportunityType', function(){
   return "success";
});*/

#Use CRUD URLs
Route::group(['prefix' => 'funding-opportunities'], function() {
    Route::resource('types', 'FundingOpportunityTypeController', ['names' => [
        'index' => 'FundingOpportunityTypes.index',
        'create' => 'FundingOpportunityTypes.create',
        'store' => 'FundingOpportunityTypes.store',
        'show' => 'FundingOpportunityTypes.show',
        'edit' => 'FundingOpportunityTypes.edit',
        'update' => 'FundingOpportunityTypes.update',
        'destroy' => 'FundingOpportunityTypes.destroy'
    ]]);

    Route::resource('/', 'FundingOpportunityController', ['names' => [
        'index' => 'FundingOpportunities.index',
        'create' => 'FundingOpportunities.create',
        'store' => 'FundingOpportunities.store',
        'show' => 'FundingOpportunities.show',
        'edit' => 'FundingOpportunities.edit',
        'update' => 'FundingOpportunities.update',
        'destroy' => 'FundingOpportunities.destroy'
    ]]);
});

Route::get('/test', function(){
   return \App\FundingOpportunityType::getDropdownHTMLList();
});



Auth::routes();

Route::get('/home', 'HomeController@index');
