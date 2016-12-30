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


Route::get('/', function () {
    return view('welcome');
});*/
Route::auth();
Route::group(['prefix' => 'reservation', 'middleware' => ['auth']], function (){
    Route::get('/', 'ReservationController@index');
    Route::get('/save', 'ReservationController@calculation');
    Route::get('/back', 'ReservationController@index');
    Route::get('/reset', 'ReservationController@reset');
});



//Route::get('/home', 'HomeController@index');
