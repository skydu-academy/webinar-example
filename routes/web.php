<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Auth::routes();

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('home', 'HomeController@index');

Route::get('first', 'FirstController@get');
Route::post('first', 'FirstController@post');
Route::put('first', 'FirstController@put');
Route::delete('first', 'FirstController@delete');

/*Route::prefix('first')->group(function () {
    Route::get('/', 'FirstController@get');
    Route::post('/', 'FirstController@post');
    Route::put('/', 'FirstController@put');
    Route::delete('/', 'FirstController@delete');

    //Route::get('second','SecondController');
});*/


Route::get('second/third/fourth/fifth','SecondController')->name('second');


Route::resource('posts', 'PostController');
Route::resource('comments', 'CommentController');

