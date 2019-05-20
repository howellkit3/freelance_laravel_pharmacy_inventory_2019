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

Route::get('/', function () {
    return view('welcome');
});

Route::get('stocks', function()
{
    return View::make('pages.stocks.index');
});
Route::get('suppliers', function()
{
    return View::make('suppliers.index');
});
Route::get('admin', function()
{
    return View::make('admin.index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
