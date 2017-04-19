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
     return view('home');
})->middleware('auth');


#Use CRUD URLs
Route::resource('funding-opportunities', 'FundingOpportunityController', ['names' => [
        'index' => 'FundingOpportunities.index',
        'create' => 'FundingOpportunities.create',
        'store' => 'FundingOpportunities.store',
        'show' => 'FundingOpportunities.show',
        'edit' => 'FundingOpportunities.edit',
        'update' => 'FundingOpportunities.update',
        'destroy' => 'FundingOpportunities.destroy'
]]);

#Use CRUD URLs
Route::resource('users', 'UserController', ['names' => [
    'index' => 'Users.index',
    'create' => 'Users.create',
    'store' => 'Users.store',
    'show' => 'Users.show',
    'edit' => 'Users.edit',
    'update' => 'Users.update',
    'destroy' => 'Users.destroy'
]]);


Route::resource('users', 'UserController');


Auth::routes();

Route::get('/home', 'HomeController@index');

/* the big to-do list
1. group_user needs a controller to control users getting added to group.  Use sync--figureo uto how it handles detach.
2. let admins create users.
3. math phd students
4. home page should be a layout of apps.
5. public API for accessing fundingopportunities.
*/
