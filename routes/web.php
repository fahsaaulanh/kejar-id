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

Route::get('/login', 'LoginController@index');
Route::post('/login/doLogin', 'LoginController@login');

Route::middleware('session')->group(function () {
    Route::get('/', 'HomeController@index');
    Route::get('/logout', 'HomeController@logout');

    Route::middleware('admin')->group(function() {
         // Khusus route admin disini
        Route::get('/admin', 'HomeController@admin');
        Route::prefix('/admin')->group(function(){
            Route::prefix('{game}')->group(function(){
                Route::get('/', 'Admin\StageController@index');

                Route::post('/upload', 'Admin\StageController@upload');
                Route::patch('/{stageId}/order', 'Admin\StageController@order');
                Route::prefix('{stage}')->group(function(){
                    Route::get('/', 'RoundController@index');
                    Route::get('/edit/{id}', 'RoundController@edit');
                    Route::post('/import', 'RoundController@import');
                    Route::post('/order/update', 'RoundController@updateOrder');
                    Route::patch('/status', 'Round\RoundController@updateStatus');
                    Route::post('/upload', 'Round\RoundController@uploadFile');
                });
            });
        });
    });

    Route::middleware('teacher')->group(function() {
         // Khusus route teacher disini
        Route::get('/teacher', 'HomeController@teacher');
    });

    Route::middleware('student')->group(function() {
         // Khusus route student disini
        Route::get('/student', 'HomeController@student');
    });
});
