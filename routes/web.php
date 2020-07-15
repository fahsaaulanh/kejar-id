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
Route::post('/login', 'LoginController@login');

Route::middleware('session')->group(function () {
    Route::get('/dashboard', 'HomeController@dashboard');
    Route::get('/logout', 'HomeController@logout');

    Route::middleware('admin')->group(function () {

        Route::get('/admin', 'HomeController@admin');

        // example
        Route::get('/example-header', fn () => view('example/withHeader'));

        Route::get('/example-noheader', fn () => view('example/withoutHeader'));
        // end of example

        Route::prefix('/admin')->group(function () {

            Route::prefix('{game}/stages')->group(function () {
                Route::get('/', 'Admin\StageController@index');
                Route::post('/upload', 'Admin\StageController@upload');
                Route::post('/create', 'Admin\StageController@create');
                Route::patch('/{stageId}/order', 'Admin\StageController@order');

                Route::prefix('{stageId}/rounds')->group(function () {
                    Route::get('/', 'Admin\RoundController@index');
                    Route::get('/edit/{roundId}', 'Admin\RoundController@edit');
                    Route::post('/order/update', 'Admin\RoundController@updateOrder');
                    Route::patch('{roundId}/status', 'Admin\RoundController@updateStatus');
                    Route::post('/upload', 'Admin\RoundController@uploadFile');
                    Route::post('/create', 'Admin\RoundController@createRound');
                    Route::post('/upload/questions', 'Admin\QuestionController@uploadFile');
                    Route::post('/modal/round/update/{id}', 'Admin\RoundModalController@updateRoundModal');

                    Route::prefix('{roundId}/questions')->group(function () {
                        Route::get('/', 'Admin\QuestionController@index');
                        Route::post('/', 'Admin\QuestionController@storeQuestion');
                    });
                });
            });
        });
    });

    Route::middleware('teacher')->group(function () {
         // Khusus route teacher disini
        Route::get('/teacher', 'HomeController@teacher');
    });

    Route::middleware('student')->group(function () {

         // Khusus route student disini
        Route::get('/student', 'HomeController@student');

        Route::prefix('student')->group(function () {
            Route::get('/result', 'Student\ResultController@index'); //TODO EXAM

            Route::prefix('/{game}/stages')->group(function () {

                Route::get('/', 'Student\GameController@index');

                Route::prefix('/{stageId}/rounds')->group(function () {

                    Route::get('/', 'Student\RoundController@index');

                    // exam
                    Route::get('{roundId}/onboarding', 'Student\OnBoardingController@index');
                    Route::get('{roundId}/exam', 'Student\MatrikulasiExamController@index');
                    Route::post('{roundId}/check', 'Student\MatrikulasiExamController@checkAnswer');
                    Route::post('{roundId}/{taskId}/finish', 'Student\MatrikulasiExamController@finish');
                });
            });
        });
        Route::get('/{game}/{stageId}/{roundId}', 'Student\MatrikulasiExamController@index');
        Route::post('/{game}/{stageId}/{roundId}/check-answer', 'Student\MatrikulasiExamController@checkAnswer');
    });
});
