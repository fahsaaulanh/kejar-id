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
Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

Route::middleware('session')->group(function () {
    Route::get('/logout', 'HomeController@logout');

    Route::middleware('admin')->group(function () {

        Route::get('/admin/games', 'HomeController@admin');

        // example
        Route::get('/example-header', fn () => view('example/withHeader'));

        Route::get('/example-noheader', fn () => view('example/withoutHeader'));
        // end of example

        Route::prefix('/admin')->group(function () {

            // Mini Assesments

            Route::post('mini-assessment/tracking-code', 'Admin\MiniAssessmentController@trackingCode');
            Route::post('mini-assessment/upload-answers', 'Admin\MiniAssessmentController@uploadAnswers');
            Route::post('mini-assessment/edit-answers', 'Admin\MiniAssessmentController@editAnswers');
            Route::post('mini-assessment/edit-schedule', 'Admin\MiniAssessmentController@editSchedule');
            Route::post('mini-assessment/create-answers', 'Admin\MiniAssessmentController@createAnswers');
            Route::get('mini-assessment/view/{id}', 'Admin\MiniAssessmentController@view');
            Route::post('mini-assessment/export', 'Admin\MiniAssessmentController@export');

            Route::prefix('mini-assessment/{mini_assessment_group}')->group(function () {
                Route::get('/', 'Admin\MiniAssessmentController@subjects');

                Route::prefix('subject/{subject_id}/{grade}')->group(function () {
                    Route::get('/', 'Admin\MiniAssessmentController@index');
                    Route::post('/', 'Admin\MiniAssessmentController@create');
                    Route::patch('/', 'Admin\MiniAssessmentController@update');
                });
            });

            Route::patch('/change-password', 'Shared\ChangePasswordController@update');

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
                            Route::get('/{questionId}', 'Admin\QuestionController@editQuestion');
                            Route::patch('/{questionId}', 'Admin\QuestionController@updateQuestion');
                        });
                    });
                });
            });

            // Paket
            Route::prefix('{game}/packages')->group(function () {
                Route::get('/', 'Admin\PackageController@index');
                Route::post('/', 'Admin\PackageController@store');
                Route::patch('/{packageId}/order', 'Admin\PackageController@order');

                Route::prefix('{packageId}/units')->group(function () {
                    Route::get('/', 'Admin\UnitController@index');
                    Route::post('/', 'Admin\UnitController@store');
                    Route::patch('/order', 'Admin\UnitController@order');
                    Route::patch('/update-package', 'Admin\PackageController@update');

                    Route::prefix('{unitId}')->group(function () {
                        Route::get('/', 'Admin\LiterasiController@index');
                        Route::patch('/', 'Admin\UnitController@update');
                        Route::prefix('/questions')->group(function () {
                            Route::post('/', 'Admin\LiterasiController@store');
                            Route::get('{questionId}', 'Admin\LiterasiController@show');
                            Route::patch('{questionId}', 'Admin\LiterasiController@update');
                        });
                    });
                });
            });
        });
    });

    Route::middleware('teacher')->group(function () {

        // Khusus route teacher disini

        Route::prefix('teacher')->group(function () {

            // API
            Route::get('/api/assessment-groups', 'HomeController@getAssessmentGroups');
            Route::post('/api/assessment-groups', 'HomeController@createAssessmentGroup');
            //

            // Assessments
            Route::prefix('subject-teacher')->group(function () {
                Route::get('{assessmentGroupId}/subject', 'Teacher\AssessmentController@subjects');
                Route::get(
                    '{assessmentGroupId}/subject/{subjectId}/{grade}/assessment',
                    'Teacher\AssessmentController@assessment',
                );
                Route::post(
                    '{assessmentGroupId}/subject/{subjectId}/{grade}/assessment',
                    'Teacher\AssessmentController@createMiniAssessment',
                );
                Route::patch(
                    '{assessmentGroupId}/subject/{subjectId}/{grade}/assessment/{miniAssessmentId}',
                    'Teacher\AssessmentController@settingMiniAssessment',
                );
                Route::get('mini-assessment/view/{id}', 'Teacher\AssessmentController@viewMini');
            });

            //

            // Mini Assesments

            Route::get('mini-assessment/view/{id}', 'Teacher\MiniAssessmentController@view');

            Route::post('mini-assessment/update-presence', 'Teacher\MiniAssessmentController@updatePresence');
            Route::post('mini-assessment/attendance-form/{id}', 'Teacher\MiniAssessmentController@attendanceForm');
            Route::post('mini-assessment/validation', 'Teacher\MiniAssessmentController@validation');
            Route::post('mini-assessment/index-package', 'Teacher\MiniAssessmentController@packageData');
            Route::post('mini-assessment/index-school-group', 'Teacher\MiniAssessmentController@schoolGroupData');
            Route::post(
                'mini-assessment/score-by-student-group',
                'Teacher\MiniAssessmentController@scoreBystudentGroupData',
            );
            Route::post('mini-assessment/update-score', 'Teacher\MiniAssessmentController@updateScore');
            Route::post('mini-assessment/update-note', 'Teacher\MiniAssessmentController@updateNote');

            Route::get('/mini-assessment/score', 'Teacher\MiniAssessmentController@getScore');

            Route::post('/mini-assessment/student-score', 'Teacher\MiniAssessmentController@studentScore');

            Route::post(
                '/mini-assessment/counselor-students',
                'Teacher\MiniAssessmentController@getStudentByCounselor',
            );

            Route::prefix('{type}/mini-assessment/{mini_assessment_group}')->group(function () {
                Route::get('/', 'Teacher\MiniAssessmentController@subjects');

                // Rayon

                Route::get('/list', 'Teacher\MiniAssessmentController@list');
                Route::get('/{studentCounselorId}/detail', 'Teacher\MiniAssessmentController@report');

                // End Rayon

                Route::get('subject/{subject_id}/{grade}', 'Teacher\MiniAssessmentController@package');
                Route::get(
                    'subject/{subject_id}/{grade}/batch/{batch_id}/score/{studentGroupId}',
                    'Teacher\MiniAssessmentController@scoreBystudentGroup',
                );
                Route::post(
                    'subject/{subject_id}/{grade}/batch/{batch_id}/score/{studentGroupId}/export',
                    'Teacher\MiniAssessmentController@scoreBystudentGroupExport',
                );
            });

            Route::patch('/change-password', 'Shared\ChangePasswordController@update');
            Route::patch('/change-profile', 'Shared\ChangeProfileController@update');
            Route::get('/skip-change-info', 'Shared\ChangePasswordController@skip');

            Route::prefix('/games')->group(function () {

                Route::get('/', 'HomeController@teacher');

                Route::prefix('/{game}/class')->group(function () {

                    Route::get('/', 'Teacher\StageController@index');

                    Route::prefix('{batchId}/{studentGroupId}/stages')->group(function () {

                        Route::get('/', 'Teacher\StageController@resultStage');

                        Route::get('/{studentId}/detail', 'Teacher\RoundController@modal');

                        Route::prefix('/{stageId}/rounds')->group(function () {

                            Route::get('/', 'Teacher\RoundController@index');

                            Route::prefix('/{roundId}')->group(function () {

                                Route::get('/description', 'Teacher\RoundController@description');
                            });
                        });
                    });
                });
            });
        });
    });

    Route::middleware('student')->group(function () {

        // Khusus route student disini

        Route::prefix('student')->group(function () {

            Route::get('/', 'HomeController@index');
            Route::get('/api/assessment-groups', 'HomeController@getAssessmentGroups');

            Route::prefix('/mini_assessment')->group(function () {
                Route::get('/', 'Student\MiniAssessmentController@index');
                Route::post('/view-detail', 'Student\MiniAssessmentController@viewDetail');
                Route::post('/get-subject', 'Student\MiniAssessmentController@getSubject');
                Route::get('/{subject_id}', 'Student\MiniAssessmentController@detail');
                Route::get('/{subject_id}/exam', 'Student\MiniAssessmentController@exam');
                Route::get('/exam/pdf', 'Student\MiniAssessmentController@print')->name('printAnswer');
                Route::get('/exam/close', 'Student\MiniAssessmentController@close')->name('close');



                // Route For Call API
                Route::get('/service/subjects', 'Student\MiniAssessmentController@subjects');
                Route::get('/service/subjects/{subject_id}', 'Student\MiniAssessmentController@detail');
                Route::post('/service/answer', 'Student\MiniAssessmentController@setAnswer');
                Route::post('/service/finish', 'Student\MiniAssessmentController@finish');
                Route::get('/service/check', 'Student\MiniAssessmentController@checkAnswer');
                Route::patch('/service/edit_note', 'Student\MiniAssessmentController@editNote');
            });

            Route::patch('/change-password', 'Shared\ChangePasswordController@update');
            Route::patch('/change-profile', 'Shared\ChangeProfileController@update');
            Route::get('/result', 'Student\ResultController@index'); //TODO EXAM
            Route::get('/skip-change-info', 'Shared\ChangePasswordController@skip'); //TODO EXAM

            Route::prefix('/games')->group(function () {

                Route::get('/', 'HomeController@student');

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
                            Route::get('/{taskId}/result', 'Student\MatrikulasiExamController@result');
                        });
                    });
                });
            });
        });
        Route::get('/{game}/{stageId}/{roundId}', 'Student\MatrikulasiExamController@index');
        Route::post('/{game}/{stageId}/{roundId}/check-answer', 'Student\MatrikulasiExamController@checkAnswer');
    });
});
