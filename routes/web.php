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


//Global Constants -- Use this for readability and ensure it matches the "Groups" database.
Route::group(['prefix' => ''], function() {
    //Authentication
    define('AUTH_LDAP_ENABLED',true);
    //Application IDs in Groups DB
    define('APP_SUPERUSER','1');
    define('APP_FUNDINGOPPORTUNITIES','2');
    define('APP_MATHPHD','3');
    //end Application IDs
});


Route::get('/', function () {
     return view('home');
})->middleware('auth');

#Funding Opportunities
Route::get('funding-opportunities/publicIndex', 'FundingOpportunityController@publicIndex'); #public
#Backend.
Route::resource('funding-opportunities', 'FundingOpportunityController', ['names' => [
        'index' => 'FundingOpportunities.index',
        'create' => 'FundingOpportunities.create',
        'store' => 'FundingOpportunities.store',
        'show' => 'FundingOpportunities.show',
        'edit' => 'FundingOpportunities.edit',
        'update' => 'FundingOpportunities.update',
        'destroy' => 'FundingOpportunities.destroy'
]]);


Route::resource('users', 'UserController');
Route::post('/users', 'UserController@index'); #extra route needed.


Auth::routes();

Route::get('/home', 'HomeController@index');

