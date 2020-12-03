<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Assessment;
use App\Services\AssessmentGroup;
use App\Services\School;
use App\Services\School as SchoolApi;
use App\Services\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use PDF;

class MiniAssessmentController extends Controller
{
    public function miniAssessmentGroups($val, $type = 'title')
    {
        $miniAssessmentGroup = $type === 'value' ? [
            'PTS-semester-ganjil-2020-2021' => 'pts ganjil 2020-2021',
            'PTS-susulan-semester-ganjil-2020-2021' => 'pts susulan ganjil 2020-2021',
        ] : [
            'PTS Semester Ganjil 2020-2021' => 'pts ganjil 2020-2021',
            'PTS Susulan Semester Ganjil 2020-2021' => 'pts susulan ganjil 2020-2021',
        ];

        if ($type === 'header') {
            $miniAssessmentGroup = [
                'pts ganjil 2020-2021' => 'PTS Semester Ganjil 2020-2021',
                'pts susulan ganjil 2020-2021' => 'PTS Susulan Semester Ganjil 2020-2021',
            ];
        }

        return $miniAssessmentGroup[$val];
    }

    public function index()
    {
        $user = $this->request->session()->get('user', null);
        $task = $this->request->session()->get('task', null);

        $now = Carbon::now()->format('Y-m-d H:i:s');

        $data = [
            'now' => $now,
        ];

        if ($task !== null) {
            if (count($task['task']) > 0) {
                $subjectId = $task['subject_id'];

                return redirect("/student/mini_assessment/$subjectId/exam");
            }
        }

        if (!$user) {
            return redirect('/login');
        }

        return view('student.subjects.index', $data);
    }

    public function detail($subject_id)
    {
        $subject_id;
        $this->getGrade();

        return view('student.onboarding_exam.index');

        // $maService = new Assessment;
        // $taskService = new Task;

        // if ($grade === 0) {
        //     return redirect('/login');
        // }

        // $refresh = $this->request->query('refresh', 'false');
        // $save = $this->request->query('save', 'false');

        // $filter = [
        //     'filter[subject_id]' => $subject_id,
        //     'filter[grade]' => $grade,
        //     'per_page' => 50,
        // ];

        // $task = $this->request->session()->get('task', null);
        // $user = $this->request->session()->get('user', null);

        // $filterTask = [
        //     'filter[subject_id]' => $subject_id,
        //     'filter[finished]' => 'true',
        // ];

        // $responseTask = $taskService->tasksMiniAssessment($user['userable']['id'], $filterTask);
        // $tasksDone = $responseTask['error'] ? [] : $responseTask['data'] ?? [];

        // if (count($tasksDone) > 0) {
        //     return redirect('/student/mini_assessment');
        // }

        // $answers = $this->request->session()->get('answers', []);

        // // Get if Local Storage has Cleared.
        // if (!$task || $task['subject_id'] !== $subject_id || $refresh === 'true') {
        //     $response = $maService->index($filter);

        //     $datas = collect($response['data']);
        //     $dataMA = $datas->random();

        //     $responseQuestions = $taskService->questionsMiniAssessment($dataMA['id']);

        //     // Add Some Key and Value Pair
        //     $endTime = Carbon::parse($dataMA['expiry_time']);

        //     $dataMA['duration'] = $dataMA['duration'];
        //     $dataMA['start_fulldate'] = Carbon::parse($dataMA['start_time'])->format('Y-m-d H:i:s');
        //     $dataMA['expiry_fulldate'] = Carbon::parse($dataMA['expiry_time'])->format('Y-m-d H:i:s');
        //     $dataMA['start_date'] = Carbon::parse($dataMA['start_time'])->format('l, d F Y');
        //     $dataMA['start_time'] = Carbon::parse($dataMA['start_time'])->format('H.i');
        //     $dataMA['expiry_date'] = Carbon::parse($dataMA['expiry_time'])->format('l, d F Y');
        //     $dataMA['expiry_time'] = Carbon::parse($dataMA['expiry_time'])->format('H.i');

        //     $chr1 = chr(rand(97, 122));
        //     $chr2 = chr(rand(97, 122));
        //     $chr3 = chr(rand(97, 122));
        //     $chr4 = chr(rand(97, 122));
        //     $chr5 = chr(rand(97, 122));
        //     $chr6 = chr(rand(97, 122));
        //     $chr7 = chr(rand(97, 122));
        //     $chr8 = chr(rand(97, 122));
        //     //

        //     $dataMA['random_char1'] = $chr1 . $chr2 . $chr3 . $chr4;
        //     $dataMA['random_char2'] = $chr5 . $chr6 . $chr7 . $chr8;

        //     // Save to Session as Temporary
        //     $tasksSession = [
        //         'subject_id' => $subject_id,
        //         'mini_assessment' => $dataMA,
        //         'task_id' => '',
        //         'task' => [],
        //         'answers' => $responseQuestions['data'] ?? [],
        //     ];

        //     $this->request->session()->put('task', $tasksSession);
        //     $task = $tasksSession;
        //     //
        // }

        // // Save To Database if variable $save is true
        // if ($save === 'true') {
        //     $responseTask = $taskService->startMiniAssessment($task['mini_assessment']['id']);

        //     $addMinutes = $task['mini_assessment']['duration'];
        //     $endTime = Carbon::now()->addMinutes($addMinutes)->addSeconds(5)->format('Y-m-d H:i:s');

        //     $task['mini_assessment']['end_time'] = $endTime;

        //     $tasksSession = [
        //         'subject_id' => $subject_id,
        //         'mini_assessment' => $task['mini_assessment'],
        //         'task_id' => $responseTask['data']['id'] ?? '',
        //         'task' => $responseTask['data'] ?? [],
        //         'answers' => $task['answers'],
        //     ];

        //     $this->request->session()->put('task', $tasksSession);

        //     return redirect("/student/mini_assessment/$subject_id/exam");
        // }

        // if (count($answers) > 0 && $refresh !== 'true') {
        //     return redirect("/student/mini_assessment/$subject_id/exam");
        // }

        // //

        // $pageData = [
        //     'subject_id' => $subject_id,
        //     'task' => $task,
        // ];

        // return view('student.mini_assessment.subjects.detail', $pageData);
    }

    public function beforeExam()
    {
        $taskService = new Task;
        $assessmentService = new Assessment;
        $assessmentId = $this->request->query('assessment_id', null);
        $save = $this->request->query('save', 'false');

        $responseAssessment = $assessmentService->detail($assessmentId);
        $responseQuestions = $taskService->questionsAssessment($assessmentId);

        if ($responseAssessment['error']) {
            dd('ID Assessment Not Found');
        }

        $questions = $responseQuestions['data'];
        $assessment = $responseAssessment['data'];
        $assessmentGroupId = $assessment['assessment_group_id'];
        $subjectId = $assessment['subject_id'];

        if ($save === 'true') {
            $responseTask = $taskService->startAssessment($assessmentId);
            if ($responseTask['error']) {
                dd('Task Not Found');
            }

            $task = $responseTask['data'];

            $addMinutes = $assessment['duration'];
            $endTime = Carbon::now()->addMinutes($addMinutes)->addSeconds(5)->format('Y-m-d H:i:s');

            $assessment['end_time'] = $endTime;
            $assessment['questions'] = $questions;

            $answers = $this->getAnswer($task['id']);

            $tasksSession = [
                'subject_id' => $assessment['subject_id'],
                'assessment' => $assessment,
                'task_id' => $responseTask['data']['id'] ?? '',
                'task' => $responseTask['data'] ?? [],
                'answers' => $answers,
            ];

            $this->request->session()->put('task', $tasksSession);

            return redirect("/student/assessment/$assessmentGroupId/subjects/$subjectId/exam");
        } else {
            dd($assessment);
        }
    }

    public function exam()
    {

        $user = $this->request->session()->get('user', null);
        $task = $this->request->session()->get('task', null);

        if ($task === null) {
            $this->request->session()->remove('task');
            $this->request->session()->remove('answers');

            // TODO : Change this later after subject dynamic
            return redirect('/student/dashboard');
        }

        if ($task['task_id'] === '') {
            $this->request->session()->remove('task');
            $this->request->session()->remove('answers');

            // TODO : Change this later after subject dynamic
            return redirect('/student/dashboard');
        }

        // TODO : Enable this later after dynamic
        // $MiniAssessment = new Assessment;
        // $cek = $MiniAssessment->result(
        //     $user['userable']['id'],
        //     [
        //         'filter[subject_id]' => $task['subject_id'],
        //         'filter[group]' => $task['mini_assessment']['group'],
        //         'per_page' => 5,
        //     ],
        // );

        // if ($cek['error']) {
        //     $this->request->session()->remove('task');
        //     $this->request->session()->remove('answers');

        //     return redirect('/student/mini_assessment');
        // }

        // if (isset($cek['data'][0]['finish_time']) && $cek['data'][0]['finish_time']) {
        //     $this->request->session()->remove('task');
        //     $this->request->session()->remove('answers');

        //     return redirect('/student/mini_assessment')->with('message', 'Jawaban telah dikumpulkan');
        // }

        $answers = $this->getAnswer($task['task_id']);

        if (!$answers) {
            $this->request->session()->remove('task');
            $this->request->session()->remove('answers');

            return redirect('/student/dashboard');
        }

        $this->request->session()->put('answers', $answers);

        $pageData = [
            'user' => $user,
            'task' => $task,
            'answers' => $answers,
            'userable' => $user['userable'],
        ];

        // dd($pageData);

        return view('student.assessment.exam.mini.index', $pageData);
    }

    private function schoolId()
    {
        $schoolId = session()->get('user.userable.school_id');

        // prod
        $wikramaIdProd = [
            '3da67e44-ca12-4ae8-b784-f066ea605887', // bogor
            '6286566b-a2ce-4649-9c0c-078c434215af', // garut
        ];

        // staging
        $wikramaIdStaging = [
            '73ceaf53-a9d8-4777-92fe-39cb55b6fe3b', // bogor
            '35fd6bcd-2df7-414d-b7e2-20b62490d561', // garut
        ];

        if (in_array($schoolId, $wikramaIdProd)) {
            $schoolId = '3da67e44-ca12-4ae8-b784-f066ea605887';
        } elseif (in_array($schoolId, $wikramaIdStaging)) {
            $schoolId = '73ceaf53-a9d8-4777-92fe-39cb55b6fe3b';
        }

        return $schoolId;
    }

    public function getSubject(Request $req)
    {
        $schoolApi = new SchoolApi;
        $filter = [
            'page' => ($req->page ?? 1),
            // 'filter[name]' => ($req->subject_name ?? ''),
            'per_page' => 10,
        ];
        $subjects = $schoolApi->subjectIndex($this->schoolId(), $filter);

        $data = [];
        if ($subjects['error']) {
            $view = '<div class="row px-7 mt-4">
                        <div class="row bg-light py-2 w-100 justify-content-center">
                            <h4 class="text-reguler">
                            <a href="/student/12312312/subjects" class="btn btn-primary btn-lg">
                            Tampilkan Daftar Mapel </a></h4>
                        </div>
                    </div>';

            return response()->json($view);
        }

        foreach ($subjects['data'] as $key => $v) {
            $data[$key] = [
                'id' => $v['id'],
                'name' => $v['name'],
            ];
        }

        $getView = [];
        $getView['data'] = $data;
        $getView['meta'] = $subjects['meta'];
        $html = $this->getSubjectHtml($getView, (int)$req->page, $req->paginationFunction);

        return response()->json($html);
    }

    public function getSubjectHtml($getView, $page, $paginationFunction)
    {
        $list = $getView['data'];
        $meta = $getView['meta'];

        $view = '';
        foreach ($list as $v) {
            $view .= '<div class="row m-0 pt-4">';

                $view .= '<div class="row m-0 btn-accordion-subject w-100" role="button">';
                    $view .='<div class="row m-0 justify-content-between w-100">';
                        $view .= '<div class="row m-0" onclick="viewDetail(\''.$v['id'].'\',\''.$v['name'].'\')">';
                            $view .='<div class="col-md-1 p-0">';
                                    $view .='<i class="kejar-mapel"></i>';
                            $view .='</div>';
                            $view .='<div class="row m-0 pl-4 flex-column">';
                                $view .= '<div id="mapel">';
                                    $view .= '<h4>'. $v['name'] .'</h4>';
                                $view .= '</div>';

                                $view .= '<div class="pt-2">';
                                    $view .= '<h6 class="text-grey-3"> Dimulai pada 19 Nov 2020, 09.00 </h6>';
                                $view .= '</div>';

                                $view .= '<div class="pt-2">';
                                    $view .= '<h6 class="text-grey-3"> Berakhir pada 20 Nov 2020, 09.00 </h6>';
                                $view .= '</div>';
                            $view .='</div>';

                            $view .= '<div class="col-md-6 mt-2 mt-md-0 mt-lg-0 align-items-end">';
                                $view .= '<div class="row justify-content-start justify-content-md-end
                                justify-content-lg-end">';
                                $view .= '</div>';
                            $view .= '</div>';

                        $view .= '</div>';

                        $view .='<div>';
                            $view .='<i class="kejar-right"></i>';
                        $view .='</div>';
                    $view .='</div>';

            $view .= '<div class="col-md-6 mt-2 mt-md-0 mt-lg-0 align-items-end">';
            $view .= '<div class="row justify-content-start justify-content-md-end
                                justify-content-lg-end">';
            $view .= '</div>';
            $view .= '</div>';

            $view .= '</div>';

            $view .= '<div>';
            $view .= '<i class="kejar-right"></i>';
            $view .= '</div>';
            $view .= '</div>';

            $view .= '</div>';

            $view .= '</div>';
        }

        if ($meta && $meta['total'] > 10) {
            $view .= '<nav class="navigation mt-5">';
            $view .= '<div>';
            $view .= '<span class="pagination-detail">' . ($meta['to'] ?? 0)
                . ' dari ' . $meta['total'] . ' mapel</span>';
            $view .= '</div>';
            $view .= '<ul class="pagination">';
            $view .= '<li class="page-item ' . ($page - 1 <= 0 ? 'disabled' : '') . '">';
            $view .= '<a class="page-link" onclick="' . $paginationFunction . '(' . ($page - 1) . ')"
                              href="javascript:void(0)" tabindex="-1">&lt;</a>';
            $view .= '</li>';

            for ($i = 1; $i <= $meta['last_page']; $i++) {
                $view .= '<li class="page-item ' . ($page === $i ? 'active disabled' : '') . '">';
                $view .= '<a class="page-link" onclick="' . $paginationFunction . '(' . $i . ')"
                              href="javascript:void(0)">' . $i . '</a>';
                $view .= '</li>';
            }

            $view .= '<li class="page-item ' . ($page + 1) . ' > ' . ($meta['last_page'] ? 'disabled' : '') . '">';
            $view .= '<a class="page-link" onclick="' . $paginationFunction . '(' . ($page + 1) . ')"
                                  href="javascript:void(0)">&gt;</a>';
            $view .= '</li>';
            $view .= '</ul>';
            $view .= '</nav>';
        }

        return $view;
    }


    // public function viewDetail(Request $req)
    // {
    //     $id = $req->id;
    //     $maGroup = $req->assessment_group_id;
    //     $data = [
    //         'id' => $req->id,
    //         'name' => $req->name,
    //         'schedule' => '',
    //         'finished' => 0,
    //         'enabled' => 0,
    //     ];

    //     $user = $this->request->session()->get('user');
    //     $user = $this->request->in->get('user');

    //     $MiniAssessment = new Assessment;
    //     $grade = $this->getGrade();
    //     $exam = $MiniAssessment->result(
    //         $user['userable']['id'],
    //         [
    //             'filter[subject_id]' => $id,
    //             'filter[group]' => $maGroup,
    //             'per_page' => 1,
    //         ],
    //     );

    //     if (!$exam['error'] && isset($exam['data'][0])) {
    //         $data['finished'] = 1;
    //     } else {
    //         // get package info
    //         $package = $MiniAssessment->index([
    //             'per_page' => 1,
    //             'filter[subject_id]' => $id,
    //             'filter[grade]' => $grade,
    //         ]);

    //         if (!$package['error'] && isset($package['data'][0])) {
    //             $packageDetail = $package['data'][0];

    //             $time = Carbon::parse($packageDetail['start_time'])->format('l, d F Y').
    //             '<br> '.Carbon::parse($packageDetail['start_time'])->format('H.i').
    //             ' - '.Carbon::parse($packageDetail['expiry_time'])->format('H.i');
    //             $data['schedule'] = $time;

    //             $now = Carbon::now()->format('Y-m-d H:i:s');
    //             $start = Carbon::parse($packageDetail['start_time'])->format('Y-m-d H:i:s');
    //             $end = Carbon::parse($packageDetail['expiry_time'])->format('Y-m-d H:i:s');
    //             if ($now >= $start && $now <= $end) {
    //                 $data['enabled'] = 1;
    //             }
    //         } else {
    //             $data['schedule'] = 'Belum ada jadwal.';
    //         }
    //     }

    //     $view = $this->viewDetailHtml($data);

    //     return response()->json($view);
    // }

    public function viewDetailHtml($data)
    {
        $view = '<div class="row">';
        $view .= '<div class="col-12">';
        $view .= '<h5>Nama Mapel</h5>';
        $view .= '<p>' . $data['name'] . '</p>';
        $view .= '</div>';
        $view .= '</div>';

        if ($data['schedule']) {
            $view .= '<div class="row">';
            $view .= '<div class="col-12">';
            $view .= '<h5>Jadwal</h5>';
            $view .= '<p>' . $data['schedule'] . '</p>';
            $view .= '</div>';
            $view .= '</div>';
        }

        if (($data['schedule'] && $data['schedule'] !== 'Belum ada jadwal.') || $data['finished'] === 1) {
            $view .= '<div class="row">';
            $view .= '<div class="col-12">';
            $view .= '<h5>Status</h5>';
            $view .= '<p class="mt-2">';
            $view .= '<span class="badge-';
            $view .= ($data['finished'] === 1 ? 'done' : 'undone');
            $view .= ' label">';
            $view .= ($data['finished'] === 1 ? 'SUDAH DIKERJAKAN' :
                'BELUM DIKERJAKAN');
            $view .= '</span>';
            $view .= '</p>';
            $view .= '</div>';
            $view .= '</div>';
        }

        if ($data['enabled']) {
            $view .= '<div class="modal-footer text-right">';
            $view .= '<div class="text-right col-md-12 p-0">';
            $view .= '<button class="btn btn-primary pull-right"
                        onclick="goExam(\'' . $data['id'] . '\',\'' . $data['name'] . '\')">Kerjakan</button>';
            $view .= '</div>';
            $view .= '</div>';
        }

        return $view;
    }

    public function setAnswer()
    {
        $taskService = new Task;

        $answer = $this->request->input('answer');
        $answerId = $this->request->input('answer_id');

        $payload = [
            'answer' => $answer,
        ];

        $task = $this->request->session()->get('task');

        $response = $taskService->setAnswerAssessment($task['task_id'], $answerId, $payload);
        if (!$response['error']) {
            $filtered = Arr::except($response['data'], ['correct_answer', 'is_correct']);
            $response['data'] = $filtered;

            return $response;
        }

        return $response;
    }

    public function checkAnswer()
    {
        $task = $this->request->session()->get('task', []);
        $answers = $this->getAnswer($task['task_id']);

        $unanswered = 0;

        foreach ($answers as $val) {
            if ($val['answer'] === null) {
                $unanswered += 1;
            }
        }

        return response()->json([
            'error' => false,
            'unanswered' => $unanswered,
        ]);
    }

    public function finish()
    {
        $taskService = new Task;

        $task = $this->request->session()->get('task');

        $answers = $this->getAnswer($task['task_id']);

        $this->request->session()->put('answers', $answers);

        return $taskService->finishAssessment($task['task_id']);
    }

    public function editNote()
    {
        $taskService = new Task;

        $task = $this->request->session()->get('task');

        $note = $this->request->input('noteStudent');

        $payloads = [
            'student_note' => $note,
        ];

        return $taskService->noteAssessment($task['task_id'], $payloads);
    }
    // End Of API Function

    public function close()
    {
        $this->request->session()->remove('task');
        $this->request->session()->remove('answers');

        return redirect('/student/dashboard');
    }

    // Print Pdf

    public function print()
    {
        $date = Carbon::now()->format('d F Y');

        $time = Carbon::now()->format('H:i');

        $schoolService = new School;
        $assessmentGroupService = new AssessmentGroup;

        $task = $this->request->session()->get('task');

        $answers = $this->request->session()->get('answers');

        $user = $this->request->session()->get('user');

        // prod
        $wikramaIdProd = [
            '3da67e44-ca12-4ae8-b784-f066ea605887', // bogor
            '6286566b-a2ce-4649-9c0c-078c434215af', // garut
        ];

        // staging
        $wikramaIdStaging = [
            '73ceaf53-a9d8-4777-92fe-39cb55b6fe3b', // bogor
            '35fd6bcd-2df7-414d-b7e2-20b62490d561', // garut
        ];

        $schoolId = $user['userable']['school_id'];

        if (in_array($schoolId, $wikramaIdProd)) {
            $schoolId = '3da67e44-ca12-4ae8-b784-f066ea605887';
        } elseif (in_array($schoolId, $wikramaIdStaging)) {
            $schoolId = '73ceaf53-a9d8-4777-92fe-39cb55b6fe3b';
        }

        $responseSubject = $schoolService->subjectDetail($schoolId, $task['subject_id']);
        $responseAssessmentGroup = $assessmentGroupService->detail($task['assessment']['assessment_group_id']);

        $group = $responseAssessmentGroup['data']['title'] ?? '';

        $subject = $responseSubject['error'] ? '' : $responseSubject['data']['name'] ?? '';

        $pageData = [
            'user' => $user,
            'task' => $task,
            'answers' => $answers,
            'userable' => $user['userable'],
            'date' => $date,
            'time' => $time,
            'subject' => $subject,
            'group' => $group,
        ];

        $pdf = PDF::loadview('student.assessment.exam.answer', $pageData)
            ->setPaper('a4', 'potrait');

        $filename = $user['userable']['name'] . '-' . $group . '-' . $subject . '-' . $time . '.PDF';

        return $pdf->download($filename);
    }
    // End Print Pdf

    // Private Function
    private function getAnswer($taskId)
    {
        $taskService = new Task;

        $response = $taskService->answersAssessment($taskId);
        $data = [];

        if ($response['error']) {
            return $data;
        }

        if (!$response['error']) {
            foreach ($response['data'] as $val) {
                $data[$val['question_id']] = [
                    'id' => $val['id'],
                    'answer' => $val['answer'],
                ];
            }
        }

        return $data;
    }

    private function getGrade()
    {
        $user = $this->request->session()->get('user', null);

        if (!$user) {
            return 0;
        }

        $userable = $user['userable'];
        $isJuniorHighSchool = $userable['educational_stage'] === 'SMP';
        $isSeniorHighSchool = $userable['educational_stage'] === 'SMK' || $userable['educational_stage'] === 'SMA';

        $grade = 1;

        if ($isJuniorHighSchool) {
            $grade = 7;
        }

        if ($isSeniorHighSchool) {
            $grade = 10;
        }

        $yearNow = Carbon::now()->year;
        $yearBatch = (int) explode('/', $userable['entry_year'])[0];
        $yearSub = $yearNow - $yearBatch;

        return $grade + $yearSub;
    }
    // End of Private Function
}
