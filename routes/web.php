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
    Route::get('/logout', 'HomeController@logout');

    Route::middleware('admin')->group(function () {

        Route::get('/admin/games', 'HomeController@admin');

        // example
        Route::get('/example-header', fn () => view('example/withHeader'));

        Route::get('/example-noheader', fn () => view('example/withoutHeader'));
        // end of example

        Route::prefix('/admin')->group(function () {

            Route::prefix('{game}/stages')->group(function () {
                Route::get('/', 'Admin\StageController@index');
                Route::post('/', 'Admin\StageController@create');
                Route::post('/upload', 'Admin\StageController@upload');
                Route::post('/upload-rounds', 'Admin\StageController@uploadRounds');
                Route::patch('/{stageId}/order', 'Admin\StageController@order');
                Route::post('/modal/stage/update/{stageId}', 'Admin\StageController@updateStageModal');

                Route::prefix('{stageId}/rounds')->group(function () {
                    Route::get('/', 'Admin\RoundController@index');
                    Route::get('/edit/{roundId}', 'Admin\RoundController@edit');
                    Route::post('/order/update', 'Admin\RoundController@updateOrder');
                    Route::patch('{roundId}/status', 'Admin\RoundController@updateStatus');
                    Route::post('/upload', 'Admin\RoundController@uploadRoundsFile');
                    Route::post('/', 'Admin\RoundController@createRound');
                    Route::post('/upload-question', 'Admin\RoundController@uploadQuestionFile');
                    Route::post('/modal/round/update/{id}', 'Admin\RoundModalController@updateRoundModal');

                    Route::prefix('{roundId}')->group(function () {
                        Route::get('/', 'Admin\QuestionController@index');
                        Route::patch('/', 'Admin\QuestionController@update');

                        Route::prefix('questions')->group(function () {
                            Route::post('/', 'Admin\QuestionController@create');
                            Route::post('/upload', 'Admin\QuestionController@upload');
                            Route::patch('/{questionId}', 'Admin\QuestionController@updateQuestion');
                        });
                    });
                });
            });
        });
    });
    
    Route::middleware('teacher')->group(function () {

        // Khusus route teacher disini

        Route::prefix('teachers')->group(function () {

            Route::prefix('/games')->group(function () {

                Route::get('/', 'HomeController@teacher');
                
                Route::prefix('/{game}/class')->group(function () {

                    Route::get('/', 'Teacher\StageController@index');
                });
            });
        });
    });

    Route::middleware('student')->group(function () {

        // Khusus route student disini

        Route::prefix('student')->group(function () {

            Route::get('/result', 'Student\ResultController@index'); //TODO EXAM

            Route::prefix('/games')->group(function () {

                Route::get('/', 'Student\GameController@index');

                Route::prefix('/{game}/stages')->group(function () {

                    Route::get('/', 'Student\StageController@index');

                    Route::prefix('/{stageId}/rounds')->group(function () {

                        Route::get('/', 'Student\RoundController@index');

                        Route::prefix('/{roundId}')->group(function () {
                            // exam
                            Route::get('/onboardings', 'Student\OnBoardingController@index');
                            Route::get('/exams', 'Student\MatrikulasiExamController@index');
                            Route::post('/check', 'Student\MatrikulasiExamController@checkAnswer');
                            Route::post('/{taskId}/finishes', 'Student\MatrikulasiExamController@finish');
                            Route::get('/{taskId}/finishes', 'Student\MatrikulasiExamController@getFinish');
                        });
                    });
                });
            });
        });
        Route::get('/{game}/{stageId}/{roundId}', 'Student\MatrikulasiExamController@index');
        Route::post('/{game}/{stageId}/{roundId}/check-answer', 'Student\MatrikulasiExamController@checkAnswer');
    });
});
