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

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::resource('profile', 'ProfileController')->only([
        'index', 'update',
    ]);

    Route::resource('order', 'OrderController')->only([
        'create', 'store'
    ]);

    Route::group(['prefix' => 'ajax', 'namespace' => 'Ajax'], function() {
        Route::get('shops', 'ShopsController@index')->name('ajax.shops.index');
        Route::get('users', 'UsersController@index')->name('ajax.users.index');
    });
});
