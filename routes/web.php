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

Route::get('/', function () {
    return view('auth.login');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/post', 'PostController@index');
Route::post('/addPost', 'PostController@store');
Route::get('/view/{id}', 'PostController@show');
Route::get('/edit/{id}', 'PostController@edit');
Route::post('/editPost/{id}', 'PostController@editPost');
Route::get('/delete/{id}', 'PostController@delete');

Route::get('/profile', 'ProfileController@index');
Route::post('/addProfile', 'ProfileController@store');

Route::get('/category', 'CategoryController@index');
Route::post('/addCategory', 'CategoryController@store');

