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
    $age = 11;
    return view('welcome' , [  //means welcome.blade.php
        'name' => "Ryan",
    ]);
    //could "compact($age);


});

Route::get('/about', function(){
 //hard coded data
    $tasks = [
        'Get pizza',
        'go to store',
    ];
    //return view('about', compact('tasks')); //means about.blade.php  dont use variable $ i guess..

    //non hard-coded data.

});

Route::get('/database', function(){
    $tasks = DB::table('tasks')->where('id', '=', 3)->get();
   return view('database', compact('tasks'));

    //If I were to return this as JUST the db query... laravel will return this as JSON!!!!  Very useful
    //return $tasks;
});

//Wildcard. in braces.
Route::get('/tasks/{id}', function($id){
    //$task = DB::table('tasks')->find($id);
    $task = cns_webtools\Task::find($id);
    //dd($task);  //Dive and dump is good for getting variable information.  Helper class for laravel.

    return view ('database.show', compact('task'));
    //database.show means resources/views/database/show.blade.php
});

Route::get('/tasks/', function(){
    //$tasks = DB::table('tasks')->get();
    $tasks = cns_webtools\Task::all(); //eloquent implementaiton.
    return view('database', compact('tasks'));

    //if you want a "compelted" task only you can do:
    //cns_webtools\task::where('completed',0)->get(); better ... way.... put this function in Task...
        //Query Scopes... add them to task model.
            //see Task.php

});

Auth::routes();

Route::get('/home', 'HomeController@index');
