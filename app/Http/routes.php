<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();
Route::get('logout', ['as' => 'logout', 'uses' => 'AppController@logout']);
Route::get('/home', 'HomeController@index');
Route::get('/inicio', ['as' => 'inicio', 'uses' => 'AppController@index']);
    Route::get('chat/{username}',['as' => 'chat', 'uses' => 'AppController@usersChat']);
    Route::get('gchat/{username}',['as' => 'gchat', 'uses' => 'AppController@groupChat']);