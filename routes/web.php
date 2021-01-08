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

            // Assessment
            Route::prefix('{type}')->group(function () {
                Route::prefix('/schools/{schoolId}')->group(function () {

                    Route::get('assessment-groups', 'Admin\AssessmentController@assessmentGroups');

                    Route::prefix('/assessment-groups/{assessmentGroupId}')->group(function () {
                        Route::get(
                            'subjects',
                            'Admin\AssessmentController@subjects',
                        );
                        Route::get(
                            'subject/{subjectId}/{grade}/assessment',
                            'Admin\AssessmentController@assessment',
                        );
                        Route::post(
                            'subject/{subjectId}/{grade}/assessment',
                            'Admin\AssessmentController@createMiniAssessment',
                        );
                        Route::patch(
                            'subject/{subjectId}/{grade}/assessment/{assessmentId}',
                            'Admin\AssessmentController@settingMiniAssessment',
                        );
                        Route::get(
                            'subject/{subjectId}/{grade}/assessment/student-group/{studentGroupId}/score',
                            'Admin\AssessmentController@score',
                        );
                        Route::get(
                            '/subject/{subjectId}/{grade}/assessment/' .
                                'student-group/{studentGroupId}/score/{taskId}/detail',
                            'Admin\AssessmentController@detailScore',
                        );
                    });
                });

                Route::post('api/assessment-groups/create', 'Admin\AssessmentController@createAssessmentGroup');
                Route::get('mini-assessment/view/{id}', 'Admin\AssessmentController@viewQuestion');
                Route::post('assessment/mini/question/update', 'Admin\AssessmentController@updateQuestion');
                Route::get('assessment/question/check/{id}', 'Admin\AssessmentController@checkQuestion');
                Route::post('assessment/question/validation', 'Admin\AssessmentController@validationQuestion');
                Route::post('assessment/question/delete', 'Admin\AssessmentController@deleteQuestion');
                Route::post('assessment/duration', 'Admin\AssessmentController@durationAssessment');
                Route::post(
                    'assessment/{assessmentId}/subject/{subjectId}/question/create',
                    'Admin\AssessmentController@createAssessQuestion',
                );
                Route::get('assessment/question/{questionId}/edit', 'Admin\AssessmentController@editQuestion');
                Route::patch(
                    'assessment/question/{questionId}/edit',
                    'Admin\AssessmentController@updateAssessQuestion',
                );

                // for Ajax
                Route::post('/get-student-group/{schoolId}', 'Admin\AssessmentController@schoolGroupData');
                Route::post('assessment/getscore', 'Admin\AssessmentController@scoreBystudentGroup');
                Route::post('assessment/update-score', 'Admin\AssessmentController@updateScore');
                Route::post('/report-student', 'Admin\AssessmentController@reportStudent');
                Route::post('/get-students/{schoolId}', 'Admin\AssessmentController@getStudents');
                Route::post('/schedules-create/{schoolId}', 'Admin\AssessmentController@schedulesCreate');
                Route::post('/schedule-delete/{schoolId}', 'Admin\AssessmentController@deleteSchedule');
                Route::post('/schedule-update/{schoolId}', 'Admin\AssessmentController@updateSchedule');

                Route::post('/student-group/{schoolId}', 'Admin\AssessmentController@studentGroupData');

                Route::post(
                    '/get-student-group-schedules/{schoolId}',
                    'Admin\AssessmentController@getStudentByStudentGroupSchedules',
                );

                Route::post('/get-student-groups', 'Admin\AssessmentController@getStudentByStudentGroup');

                Route::post('/student-attendance', 'Admin\AssessmentController@studentAttendance');

                // Update Attendance
                Route::post(
                    '/student-attendance/update/{schoolId}',
                    'Admin\AssessmentController@studentAttendanceUpdate',
                );
            });

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
            Route::post('/questions/image-upload', 'Teacher\AssessmentController@imageUpload');
            //

            // Assessments
            Route::prefix('{type}')->group(function () {
                Route::get('{assessmentGroupId}/subject', 'Teacher\AssessmentController@subjects');
                Route::get(
                    '{assessmentGroupId}/subject/{subject_id}/{grade}/student-groups',
                    'Teacher\AssessmentController@studentGroup',
                );
                Route::get(
                    '{assessmentGroupId}/subject/{subject_id}/{grade}/student-groups/{student_group_id}',
                    'Teacher\AssessmentController@studentGroupDetail',
                );
                Route::get(
                    '{assessmentGroupId}/subject/{subjectId}/{grade}/assessment/{assessType}',
                    'Teacher\AssessmentController@setTypeAssessment',
                );
                Route::get(
                    '{assessmentGroupId}/subject/{subjectId}/{grade}/assessment',
                    'Teacher\AssessmentController@assessment',
                );
                Route::post(
                    '{assessmentGroupId}/subject/{subjectId}/{grade}/assessment',
                    'Teacher\AssessmentController@createMiniAssessment',
                );
                Route::patch(
                    '{assessmentGroupId}/subject/{subjectId}/{grade}/assessment/{assessmentId}',
                    'Teacher\AssessmentController@settingMiniAssessment',
                );


                Route::get(
                    '{assessmentGroupId}/subject/{subjectId}/{grade}/assessment/student-group/{studentGroupId}/score',
                    'Teacher\AssessmentController@score',
                );

                Route::get(
                    '{assessmentGroupId}/subject/{subjectId}/{grade}/assessment/' .
                        'student-group/{studentGroupId}/score/{taskId}/detail',
                    'Teacher\AssessmentController@detailScore',
                );

                Route::get(
                    '{assessmentGroupId}/subject/{subjectId}/{grade}/assessment/status-task/{status}',
                    'Teacher\AssessmentController@studentListStatusTask',
                );

                Route::post(
                    'assessment/schedule/student-list',
                    'Teacher\AssessmentController@studentListStatusTaskData',
                );

                Route::get('mini-assessment/view/{id}', 'Teacher\AssessmentController@viewQuestion');
                Route::get(
                    'services/tasks/assessments/{id}/questions',
                    'Teacher\AssessmentController@viewQuestionDetail',
                );
                Route::post('assessment/mini/question/update', 'Teacher\AssessmentController@updateQuestion');
                Route::get('assessment/question/check/{id}', 'Teacher\AssessmentController@checkQuestion');
                Route::post('assessment/question/validation', 'Teacher\AssessmentController@validationQuestion');
                Route::post('assessment/question/delete', 'Teacher\AssessmentController@deleteQuestion');
                Route::post('assessment/duration', 'Teacher\AssessmentController@durationAssessment');
                Route::post(
                    'assessment/{assessmentId}/subject/{subjectId}/question/create',
                    'Teacher\AssessmentController@createAssessQuestion',
                );
                Route::get('assessment/question/{questionId}/edit', 'Teacher\AssessmentController@editQuestion');
                Route::patch(
                    'assessment/question/{questionId}/edit',
                    'Teacher\AssessmentController@updateAssessQuestion',
                );
                Route::post('assessment/getscore', 'Teacher\AssessmentController@scoreBystudentGroup');
                Route::post('assessment/update-score', 'Teacher\AssessmentController@updateScore');
                Route::get('assessment/export', 'Teacher\AssessmentController@export');

                // Student Counselor

                Route::get('{assessmentGroupId}/counseling-groups', 'Teacher\AssessmentController@counselingGroups');
                Route::get(
                    '{assessmentGroupId}/counseling-groups/{studentCounselorId}/subject',
                    'Teacher\AssessmentController@subjectForCounselingGroups',
                );
                Route::get(
                    '{assessmentGroupId}/counseling-groups/{studentCounselorId}/subject/{subjectId}',
                    'Teacher\AssessmentController@counselingGroupsReport',
                );

                // for Ajax

                Route::post('/get-student-group', 'Teacher\AssessmentController@schoolGroupData');
                Route::post('/report-student', 'Teacher\AssessmentController@reportStudent');
                Route::post('/get-students', 'Teacher\AssessmentController@getStudents');
                Route::post('/schedules-create', 'Teacher\AssessmentController@schedulesCreate');
                Route::post('/schedule-delete', 'Teacher\AssessmentController@deleteSchedule');
                Route::post('/schedule-update', 'Teacher\AssessmentController@updateSchedule');

                Route::post('{assessmentGroupId}/student-group', 'Teacher\AssessmentController@studentGroupData');

                Route::post(
                    '{assessmentGroupId}/get-student-group-schedules',
                    'Teacher\AssessmentController@getStudentByStudentGroupSchedules',
                );

                Route::post(
                    '{assessmentGroupId}/get-student-groups',
                    'Teacher\AssessmentController@getStudentByStudentGroup',
                );

                Route::post(
                    '{assessmentGroupId}/student-attendance',
                    'Teacher\AssessmentController@studentAttendance',
                );

                // Update Attendance
                Route::post(
                    '{assessmentGroupId}/student-attendance/update',
                    'Teacher\AssessmentController@studentAttendanceUpdate',
                );

                // Homeroom Teacher
                Route::get('/{assessmentGroupId}/student-groups', 'Teacher\AssessmentController@studentGroups');
                Route::get(
                    '/{assessmentGroupId}/student-groups/{studentGroupId}/subjects',
                    'Teacher\AssessmentController@studentGroupSubject',
                );
                Route::get(
                    '/{assessmentGroupId}/student-groups/{studentGroupId}/subjects/{subjectId}/score',
                    'Teacher\AssessmentController@studentGroupScore',
                );
            });

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
                '/mini-assessment/student-groups',
                'Teacher\MiniAssessmentController@getStudentByStudentGroup',
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

            // Supervisor
            Route::prefix('{type}/{mini_assessment_group_id}')->group(function () {
                Route::get('subject', 'Teacher\MiniAssessmentController@subjects');
                Route::get('subject/{subject_id}/{grade}/student-groups', 'Teacher\MiniAssessmentController@package');
                Route::get(
                    'subject/{subject_id}/{grade}/student-groups/{id}',
                    'Teacher\MiniAssessmentController@attendance',
                );
            });

            Route::post(
                '/mini-assessment/counselor-students',
                'Teacher\MiniAssessmentController@getStudentByCounselor',
            );

            Route::post(
                '/mini-assessment/student-attendance',
                'Teacher\MiniAssessmentController@studentAttendance',
            );

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
            Route::get('/dashboard', 'HomeController@student');
            Route::get('/api/assessment-groups', 'HomeController@getAssessmentGroups');
            Route::get('/{assessment_group_id}/subjects', 'Student\AssessmentController@schedules');
            Route::post('/me/schedules/assessments', 'Student\AssessmentController@getSchedules');
            Route::get(
                '/{assessment_group_id}/subjects/{schedule_id}/onboarding',
                'Student\AssessmentController@detail',
            );
            Route::get(
                '/{assessment_group_id}/subjects/{assessment_id}/proceed/{schedule_id}',
                'Student\AssessmentController@proceed',
            );

            Route::prefix('/subjects')->group(function () {
                Route::get('/', 'Student\MiniAssessmentController@index');
                Route::post('/view-detail', 'Student\MiniAssessmentController@viewDetail');
                Route::post('/get-subject', 'Student\MiniAssessmentController@getSubject');
                Route::get('/{subject_id}', 'Student\MiniAssessmentController@detail');
                Route::get('/{subject_id}/exam', 'Student\MiniAssessmentController@exam');
                Route::get('/exam/pdf', 'Student\MiniAssessmentController@print')->name('printAnswer');
                Route::get('/exam/close', 'Student\MiniAssessmentController@close');

                // Route For Call API
                Route::get('/service/subjects', 'Student\MiniAssessmentController@subjects');
                Route::get('/service/subjects/{subject_id}', 'Student\MiniAssessmentController@detail');
                Route::post('/service/answer', 'Student\MiniAssessmentController@setAnswer');
                Route::post('/service/finish', 'Student\MiniAssessmentController@finish');
                Route::get('/service/check', 'Student\MiniAssessmentController@checkAnswer');
                Route::patch('/service/edit_note', 'Student\MiniAssessmentController@editNote');
            });

            Route::get('/', 'HomeController@index');

            Route::prefix('/assessment')->group(function () {
                Route::get('/{assessment_group_id}/subjects', 'Student\MiniAssessmentController@index');
                Route::get(
                    '/{assessment_group_id}/subjects/{subject_id}/onboarding',
                    'Student\MiniAssessmentController@detail',
                );
                Route::get(
                    '/{assessment_group_id}/subjects/{subject_id}/exam',
                    'Student\MiniAssessmentController@exam',
                );
                Route::get(
                    '/{assessment_group_id}/subjects/{subject_id}/close',
                    'Student\MiniAssessmentController@close',
                );

                // Route For Call API
                Route::prefix('/service')->group(function () {
                    Route::get('/subjects', 'Student\MiniAssessmentController@subjects');
                    Route::get('/subjects/{subject_id}', 'Student\MiniAssessmentController@detail');
                    Route::get('/questions', 'Student\AssessmentController@getQuestions');
                    Route::post('/answer', 'Student\MiniAssessmentController@setAnswer');
                    Route::post('/finish', 'Student\MiniAssessmentController@finish');
                    Route::get('/check', 'Student\MiniAssessmentController@checkAnswer');
                    Route::patch('/edit_note', 'Student\AssessmentController@editNote');
                });

                Route::get('/exam/pdf', 'Student\MiniAssessmentController@print')->name('printAnswer');
            });

            Route::prefix('/mini_assessment')->group(function () {
                Route::get('/', 'Student\MiniAssessmentController@index');
                Route::post('/view-detail', 'Student\MiniAssessmentController@viewDetail');
                Route::post('/get-subject', 'Student\MiniAssessmentController@getSubject');
                Route::get('/{subject_id}', 'Student\MiniAssessmentController@detail');
                Route::get('/{subject_id}/exam', 'Student\MiniAssessmentController@exam');
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

                Route::prefix('api/{game}')->group(function () {
                    Route::get('stages', 'Student\StageController@getIndex');
                    Route::get('stages/{stageId}/rounds', 'Student\RoundController@getIndex');
                });
            });
        });

        Route::get('/{game}/{stageId}/{roundId}', 'Student\MatrikulasiExamController@index');
        Route::post('/{game}/{stageId}/{roundId}/check-answer', 'Student\MatrikulasiExamController@checkAnswer');
    });

    // for global services
    Route::middleware('service')->group(function () {
    });
});
