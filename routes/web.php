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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');



Route::get('/', 'TicketsController@index');
Route::get('/home', 'TicketsController@index');
Route::get('/tickets', 'TicketsController@index');

Route::get('/tickets/create', 'TicketsController@create');
Route::post('/tickets', 'TicketsController@store');
Route::get('/tickets/{ticket}', 'TicketsController@show');
Route::get('/tickets/{ticket}/edit', 'TicketsController@edit');

Route::get('/tickets/{ticket}/assign', 'TicketsController@assign');
Route::post('/tickets/{ticket}/assign', 'TicketsController@storeAssign');
Route::get('/tickets/{ticket}/take', 'TicketsController@storeTake');
Route::post('/tickets/{ticket}/update', 'TicketsController@update');

Route::post('/tickets/{ticket}/replies', 'RepliesController@store');
