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
Route::get('/tickets/mine', 'TicketsController@mine');
Route::get('/tickets/create', 'TicketsController@create');
Route::post('/tickets', 'TicketsController@store');
Route::get('/tickets/{ticket}', 'TicketsController@show');
Route::get('/tickets/{ticket}/edit', 'TicketsController@edit');

Route::get('/tickets/{ticket}/assign', 'TicketsController@assign');
Route::post('/tickets/{ticket}/assign', 'TicketsController@storeAssign');
Route::get('/tickets/{ticket}/take', 'TicketsController@storeTake');
Route::post('/tickets/{ticket}/update', 'TicketsController@update');
Route::get('/tickets/{ticket}/closeStatus', 'TicketsController@closeStatus');
Route::get('/tickets/{ticket}/openStatus', 'TicketsController@openStatus');

Route::post('/tickets/{ticket}/replies', 'RepliesController@store');

Route::get('/ticketTypes', 'TicketTypesController@index');
Route::get('/ticketTypes/create', 'TicketTypesController@create');
Route::get('/ticketTypes/{ticketType}/edit', 'TicketTypesController@edit');
Route::post('/ticketTypes/{ticketType}/update', 'TicketTypesController@update');
Route::get('/ticketTypes/{ticketType}/delete', 'TicketTypesController@destroy');
Route::post('/ticketTypes/store', 'TicketTypesController@store');

Route::get('/users', 'UsersController@index');
Route::get('/users/{user}/edit', 'UsersController@edit');
Route::post('/users/{user}/update', 'UsersController@update');
Route::get('/users/{user}/makeEngineer', 'UsersController@makeEngineer');
