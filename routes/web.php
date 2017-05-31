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
    //Application IDs in Groups DB These need to match.
    define('APP_SUPERUSER','1');
    define('APP_FUNDINGOPPORTUNITIES','2');
    define('APP_MATHPHDS','3');
    //end Application IDs
});


Route::get('/', function () {
     return view('home');
})->middleware('auth');

#Funding Opportunities

#Backend.
Route::resource('funding-opportunities', 'FundingOpportunityController', ['names' => [
    'index' => \App\Group::find(APP_FUNDINGOPPORTUNITIES)->route_prefix.'.index',
    'create' => \App\Group::find(APP_FUNDINGOPPORTUNITIES)->route_prefix.'.create',
    'store' => \App\Group::find(APP_FUNDINGOPPORTUNITIES)->route_prefix.'.store',
    'show' => \App\Group::find(APP_FUNDINGOPPORTUNITIES)->route_prefix.'.show',
    'edit' => \App\Group::find(APP_FUNDINGOPPORTUNITIES)->route_prefix.'.edit',
    'update' => \App\Group::find(APP_FUNDINGOPPORTUNITIES)->route_prefix.'.update',
    'destroy' => \App\Group::find(APP_FUNDINGOPPORTUNITIES)->route_prefix.'.destroy'
]]);

#Math Phds
#Backend.
Route::resource('math-phds', 'MathPhdController', ['names' => [
    'index' => \App\Group::find(APP_MATHPHDS)->route_prefix.'.index',
    'create' => \App\Group::find(APP_MATHPHDS)->route_prefix.'.create',
    'store' => \App\Group::find(APP_MATHPHDS)->route_prefix.'.store',
    'show' => \App\Group::find(APP_MATHPHDS)->route_prefix.'.show',
    'edit' => \App\Group::find(APP_MATHPHDS)->route_prefix.'.edit',
    'update' => \App\Group::find(APP_MATHPHDS)->route_prefix.'.update',
    'destroy' => \App\Group::find(APP_MATHPHDS)->route_prefix.'.destroy'
]]);


Route::resource('users', 'UserController');
Route::post('/users', 'UserController@index'); #extra route needed.


Auth::routes();

Route::get('/home', 'HomeController@index');

#API's (allow data retrieval without authentication)
Route::group(['prefix' => 'api/'], function() {
    #FundingOpportunity APIs
    Route::get('funding-opportunities/', 'FundingOpportunityController@publicIndex');
    Route::get('math-phds/', 'FundingOpportunityController@publicIndex');
});
