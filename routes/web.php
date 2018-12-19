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

Route::get('/', 'RaveController@index');
Route::post('/cardCharge', 'RaveController@initialize')->name('send');
Route::post('/rave/callback', 'RaveController@callback')->name('callback');
Route::get('/transfer', 'RaveController@initiateTransfer');
Route::get('/success', 'RaveController@success');
Route::get('/failed', 'RaveController@failed');
Route::post('/rave/webhook', 'RaveController@webhook')->name('webhook');