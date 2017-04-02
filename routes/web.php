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

Route::get('/', 'PageController@index')->name('index');
Route::get('/professor', 'PageController@index')->name('professor_list');
Route::get('/subject', 'PageController@index')->name('subject_list');
Route::get('/classroom', 'PageController@index')->name('classroom_list');
Route::get('/day', 'PageController@index')->name('day_list');
Route::get('/help', 'PageController@index')->name('help');
Route::get('/group/{id}', 'PageController@index')->name('cluster');


Route::get('/test', 'TestController@test')->name('test');
