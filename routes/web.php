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

Route::get('/', 'HomeController@index');
Route::get('/login', 'LoginController@index');
Route::post('/login/doLogin', 'LoginController@login');

Route::middleware('session')->group(function () {
    Route::get('/dashboard', 'HomeController@dashboard');
    Route::get('/logout', 'HomeController@logout');

    Route::middleware('admin')->group(function() {

        Route::get('/admin', 'HomeController@admin');

        Route::prefix('/admin')->group(function(){

            Route::prefix('{game}/stages')->group(function(){
                Route::get('/', 'Admin\StageController@index');
                Route::post('/upload', 'Admin\StageController@upload');
                Route::patch('/{stageId}/order', 'Admin\StageController@order');

                Route::prefix('{stageId}/rounds')->group(function(){
                    Route::get('/', 'Admin\RoundController@index');
                    Route::get('/edit/{roundId}', 'Admin\RoundController@edit');
                    Route::post('/order/update', 'Admin\RoundController@updateOrder');
                    Route::patch('{roundId}/status', 'Admin\RoundController@updateStatus');
                    Route::post('/upload', 'Admin\RoundController@uploadFile');
                    Route::post('/upload/questions', 'Admin\QuestionController@uploadFile');
                    Route::post('/modal/round/update/{id}', 'Admin\roundModalController@updateRoundModal');

                    Route::prefix('{roundId}/questions')->group(function(){
                        Route::get('/', 'Admin\QuestionController@index');
                        Route::post('/', 'Admin\QuestionController@storeQuestion');
                    });
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
