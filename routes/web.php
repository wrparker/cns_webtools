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
    include_once(base_path('app/includes/globals.inc.php'));
    //end Application IDs
});


Route::get('/', function () {
     return view('home');
})->middleware('auth');

#Funding Opportunities

Route::resource('users', 'UserController');
Route::post('/users', 'UserController@index'); #extra route needed.


Auth::routes();

Route::get('/home', 'HomeController@index');

#API's (allow data retrieval without authentication)

#TODO: We should ensure route caching is used here.
foreach(\App\Group::all() as $application){
    if($application->id !== 1){
        Route::resource($application->route_url, $application->model_name.'Controller', ['names' => [
            'index' => $application->route_prefix.'.index',
            'create' => $application->route_prefix.'.create',
            'store' => $application->route_prefix.'.store',
            'show' => $application->route_prefix.'.show',
            'edit' => $application->route_prefix.'.edit',
            'update' => $application->route_prefix.'.update',
            'destroy' => $application->route_prefix.'.destroy'
        ]]);
    }
}

#TODO: this is a closure so its not cached.  We should cache it somehow.
Route::group(['prefix' => 'api/'], function() {
    include_once(base_path('app/includes/public_API.inc.php'));
    //foreach(\App\Group::all() as $application){

   // }
//        if($application->id !== 1) {
 //       }
  //  }
     //This so we can generate automated apps quickly.
});
