<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//user crud routes
Route::get('/users', 'User\UserController@index');
Route::post('/users', 'User\UserController@store');
Route::put('/users/{id}', 'User\UserController@update');
Route::delete('/users/{id}', 'User\UserController@destroy');
