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

Route::get('/uploadfile','UploadController@create');
Route::get('/','UploadController@create');
//Route::get('/list','UploadController@index');
Route::post('/uploadfile','UploadController@store');
Route::get('/export','UploadController@export');
Route::delete('/delete/{id}','UploadController@destroy');