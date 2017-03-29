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
    //TO-DO: refactor this into a controller.
    if(Auth::check()){
        return view('home');
    }
    else{
        return view('auth.login');
    }
});


#Use CRUD URLs
Route::group(['prefix' => 'funding-opportunities'], function() {
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

Auth::routes();


Route::get('/home', 'HomeController@index');

Route::get('register', ['as' => 'auth.register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);