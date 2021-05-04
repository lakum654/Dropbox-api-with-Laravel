<?php

use Illuminate\Support\Facades\Route;

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
/*
 
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('box','DropboxController@index');
Route::any('dropbox/upload','DropboxController@upload');
Route::post('dropbox/download','DropboxController@download');
Route::get('dropbox/write','DropboxController@write');
Route::get('dropbox/read/{file}','DropboxController@read');

Route::get('xml','XmlController@index');
Route::get('xml/create','XmlController@create');

Route::get('xml/db_users','XmlController@db_users');