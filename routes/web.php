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

Route::get('/', 'MainController@index');

Route::get('/input', 'TrashController@input');

Route::get('/trashcan', 'TrashcanController@index');

Route::get('/trashcan/get', 'TrashcanController@get');
Route::get('/trashcan/add', 'TrashcanController@add');
Route::post('/trashcan/add', 'TrashcanController@db_add');
Route::post('/trashcan/update', 'TrashcanController@db_update');
Route::get('/trashcan/delete', 'TrashcanController@db_delete');

Route::get('/statistic', 'StatisticController@index');

Route::get('/login', 'LoginController@index');

Route::get('/statistic', 'AdminController@index');