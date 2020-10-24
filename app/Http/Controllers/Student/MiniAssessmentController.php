<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\MiniAssessment;
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

        return view('student.mini_assessment.subjects.index', $data);
    }

    public function detail($subject_id)
    {
        $maService = new MiniAssessment;
        $taskService = new Task;

        $grade = $this->getGrade();

        if ($grade === 0) {
            return redirect('/login');
        }

        $refresh = $this->request->query('refresh', 'false');
        $save = $this->request->query('save', 'false');

        $filter = [
            'filter[subject_id]' => $subject_id,
            'filter[grade]' => $grade,
            'per_page' => 50,
        ];

        $task = $this->request->session()->get('task', null);
        $user = $this->request->session()->get('user', null);

        $filterTask = [
            'filter[subject_id]' => $subject_id,
            'filter[finished]' => 'true',
        ];

        $responseTask = $taskService->tasksMiniAssessment($user['userable']['id'], $filterTask);
        $tasksDone = $responseTask['error'] ? [] : $responseTask['data'] ?? [];

        if (count($tasksDone) > 0) {
            return redirect('/student/mini_assessment');
        }

        $answers = $this->request->session()->get('answers', []);

        // Get if Local Storage has Cleared.
        if (!$task || $task['subject_id'] !== $subject_id || $refresh === 'true') {
            $response = $maService->index($filter);

            $datas = collect($response['data']);
            $dataMA = $datas->random();

            $responseQuestions = $taskService->questionsMiniAssessment($dataMA['id']);

            // Add Some Key and Value Pair
            $endTime = Carbon::parse($dataMA['expiry_time']);

            $dataMA['duration'] = $dataMA['duration'];
            $dataMA['start_fulldate'] = Carbon::parse($dataMA['start_time'])->format('Y-m-d H:i:s');
            $dataMA['expiry_fulldate'] = Carbon::parse($dataMA['expiry_time'])->format('Y-m-d H:i:s');
            $dataMA['start_date'] = Carbon::parse($dataMA['start_time'])->format('l, d F Y');
            $dataMA['start_time'] = Carbon::parse($dataMA['start_time'])->format('H.i');
            $dataMA['expiry_date'] = Carbon::parse($dataMA['expiry_time'])->format('l, d F Y');
            $dataMA['expiry_time'] = Carbon::parse($dataMA['expiry_time'])->format('H.i');

            $chr1 = chr(rand(97, 122));
            $chr2 = chr(rand(97, 122));
            $chr3 = chr(rand(97, 122));
            $chr4 = chr(rand(97, 122));
            $chr5 = chr(rand(97, 122));
            $chr6 = chr(rand(97, 122));
            $chr7 = chr(rand(97, 122));
            $chr8 = chr(rand(97, 122));
            //

            $dataMA['random_char1'] = $chr1 . $chr2 . $chr3 . $chr4;
            $dataMA['random_char2'] = $chr5 . $chr6 . $chr7 . $chr8;

            // Save to Session as Temporary
            $tasksSession = [
                'subject_id' => $subject_id,
                'mini_assessment' => $dataMA,
                'task_id' => '',
                'task' => [],
                'answers' => $responseQuestions['data'] ?? [],
            ];

            $this->request->session()->put('task', $tasksSession);
            $task = $tasksSession;
            //
        }

        // Save To Database if variable $save is true
        if ($save === 'true') {
            $responseTask = $taskService->startMiniAssessment($task['mini_assessment']['id']);

            $addMinutes = $task['mini_assessment']['duration'];
            $endTime = Carbon::now()->addMinutes($addMinutes)->addSeconds(5)->format('Y-m-d H:i:s');

            $task['mini_assessment']['end_time'] = $endTime;

            $tasksSession = [
                'subject_id' => $subject_id,
                'mini_assessment' => $task['mini_assessment'],
                'task_id' => $responseTask['data']['id'] ?? '',
                'task' => $responseTask['data'] ?? [],
                'answers' => $task['answers'],
            ];

            $this->request->session()->put('task', $tasksSession);

            return redirect("/student/mini_assessment/$subject_id/exam");
        }

        if (count($answers) > 0 && $refresh !== 'true') {
            return redirect("/student/mini_assessment/$subject_id/exam");
        }

        //

        $pageData = [
            'subject_id' => $subject_id,
            'task' => $task,
        ];

        return view('student.mini_assessment.subjects.detail', $pageData);
    }

    public function exam()
    {
        $user = $this->request->session()->get('user', null);
        $task = $this->request->session()->get('task', null);

        if ($task === null) {
            $this->request->session()->remove('task');
            $this->request->session()->remove('answers');

            return redirect('/student/mini_assessment');
        }

        if ($task['task_id'] === '') {
            $this->request->session()->remove('task');
            $this->request->session()->remove('answers');

            return redirect('/student/mini_assessment');
        }

        $MiniAssessment = new MiniAssessment;
        $cek = $MiniAssessment->result(
            $user['userable']['id'],
            [
                'filter[subject_id]' => $task['subject_id'],
                'filter[group]' => $task['mini_assessment']['group'],
                'per_page' => 5,
            ],
        );

        if ($cek['error']) {
            $this->request->session()->remove('task');
            $this->request->session()->remove('answers');

            return redirect('/student/mini_assessment');
        }

        if (isset($cek['data'][0]['finish_time']) && $cek['data'][0]['finish_time']) {
            $this->request->session()->remove('task');
            $this->request->session()->remove('answers');

            return redirect('/student/mini_assessment')->with('message', 'Jawaban telah dikumpulkan');
        }

        $answers = $this->getAnswer($task['task_id']);

        if (!$answers) {
            $this->request->session()->remove('task');
            $this->request->session()->remove('answers');

            return redirect('/student/mini_assessment');
        }

        $this->request->session()->put('answers', $answers);

        $pageData = [
            'user' => $user,
            'task' => $task,
            'answers' => $answers,
            'userable' => $user['userable'],
        ];

        return view('student.mini_assessment.exam.index', $pageData);
    }

    private function schoolId()
    {
        return session()->get('user.userable.school_id');
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
                            <a href="/student/mini_assessment" class="btn btn-primary btn-lg">
                            Tampilkan Daftar Mapel </a></h4>
                        </div>
                    </div>';

            return response()->json($view);
        }

        $user = $this->request->session()->get('user');
        $MiniAssessment = new MiniAssessment;

        $maGroup = $this->miniAssessmentGroups($req->mini_assessment);
        $grade = $this->getGrade();
        foreach ($subjects['data'] as $key => $v) {
            $data[$key] = [
                'id' => $v['id'],
                'name' => $v['name'],
            ];
            $data[$key]['schedule'] = '';
            $data[$key]['finished'] = 0;
            $data[$key]['enabled'] = 0;

            // get exam

            $exam = $MiniAssessment->result(
                $user['userable']['id'],
                [
                    'filter[subject_id]' => $v['id'],
                    'filter[group]' => $maGroup,
                    'per_page' => 1,
                ],
            );
            if (!$exam['error'] && isset($exam['data'][0])) {
                $data[$key]['finished'] = 1;
            } else {
                // get package info
                $package = $MiniAssessment->index([
                    'per_page' => 1,
                    'filter[subject_id]' => $v['id'],
                    'filter[grade]' => $grade,
                ]);

                if (!$package['error'] && isset($package['data'][0])) {
                    $packageDetail = $package['data'][0];

                    $time = Carbon::parse($packageDetail['start_time'])->format('l, d F Y').
                    '<br> '.Carbon::parse($packageDetail['start_time'])->format('H.i').
                    ' - '.Carbon::parse($packageDetail['expiry_time'])->format('H.i');
                    $data[$key]['schedule'] = $time;

                    $now = Carbon::now()->format('Y-m-d H:i:s');
                    $start = Carbon::parse($packageDetail['start_time'])->format('Y-m-d H:i:s');
                    $end = Carbon::parse($packageDetail['expiry_time'])->format('Y-m-d H:i:s');
                    if ($now >= $start && $now <= $end) {
                        $data[$key]['enabled'] = 1;
                    }
                }
            }
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
        $view .= '<div class="row">';
            $view .= '<div class="col-12 p-0">';
                $view .= '<h6 class="grey-6 text-reguler">Diurutkan A-Z.</h6>';
            $view .= '</div>';
        $view .= '</div>';
        foreach ($list as $v) {
            $view .= '<div class="row mt-4">';

                $view .= '<div class="btn-accordion';
                    $view .= ($v['enabled'] === 1 ? '' : '-disabled' );
                    $view .= '"';
                    $view .= ($v['enabled'] === 1 ? 'role="button"' : '' );
                $view .= '">';

                        $view .= '<div class="row" ';
            if ($v['enabled'] === 1) {
                $view .= 'onclick="goExam(\''.$v['id'].'\',\''.$v['name'].'\')"';
            }

                        $view .= '>';

                            $view .= '<div class="col-md-6" id="mapel">';
                                $view .= '<h4>'. $v['name'] .'</h4>';
                                $view .= '<h5 class="text-reguler">'. $v['schedule'] .'</h5>';
                            $view .= '</div>';
                            $view .= '<div class="col-md-6 mt-2 mt-md-0 mt-lg-0 align-items-end">';
                                $view .= '<div class="row justify-content-start justify-content-md-end
                                justify-content-lg-end">';
                                    $view .= '<div class="col-auto">';

            if ($v['schedule'] || $v['finished'] === 1) {
                $view .= '<span class="badge-';
                    $view .= ($v['finished'] === 1 ? 'done' : 'undone' );
                $view .= ' label">';
                    $view .= ($v['finished'] === 1 ? 'SUDAH DIKERJAKAN' :
                                'BELUM DIKERJAKAN' );
                $view .= '</span>';
            }

                                        $view .= '</div>';
                                $view .= '</div>';
                            $view .= '</div>';
                        $view .= '</div>';

                $view .= '</div>';
            $view .= '</div>';
        }

        if ($meta && $meta['total'] > 10) {
            $view .= '<nav class="navigation mt-5">';
                $view .= '<div>';
                    $view .= '<span class="pagination-detail">'. ($meta['to'] ?? 0)
                            .' dari '. $meta['total'] .' mapel</span>';
                $view .= '</div>';
                $view .= '<ul class="pagination">';
                    $view .= '<li class="page-item '.($page - 1 <= 0 ? 'disabled' : '').'">';
                        $view .= '<a class="page-link" onclick="'.$paginationFunction.'('.($page - 1).')"
                              href="javascript::void(0)" tabindex="-1">&lt;</a>';
                    $view .= '</li>';

            for ($i=1; $i <= $meta['last_page']; $i++) {
                $view .= '<li class="page-item '. ($page === $i ? 'active disabled' : '') .'">';
                    $view .= '<a class="page-link" onclick="'.$paginationFunction.'('.$i.')"
                              href="javascript::void(0)">'.$i.'</a>';
                $view .= '</li>';
            }

                    $view .= '<li class="page-item '. ($page + 1).' > '.($meta['last_page'] ? 'disabled' : '' ).'">';
                        $view .= '<a class="page-link" onclick="'.$paginationFunction.'('.($page + 1).')"
                                  href="javascript::void(0)">&gt;</a>';
                    $view .= '</li>';
                $view .= '</ul>';
            $view .= '</nav>';
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

        $response = $taskService->setAnswerMiniAssessment($task['task_id'], $answerId, $payload);
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

        return $taskService->finishMiniAssessment($task['task_id']);
    }

    public function editNote()
    {
        $taskService = new Task;

        $task = $this->request->session()->get('task');

        $note = $this->request->input('noteStudent');

        $payloads = [
            'student_note' => $note,
        ];

        return $taskService->noteMiniAssessment($task['task_id'], $payloads);
    }
    // End Of API Function

    public function close()
    {
        $this->request->session()->remove('task');
        $this->request->session()->remove('answers');

        return redirect('/student/mini_assessment');
    }

    // Print Pdf

    public function print()
    {
        $date = Carbon::now()->format('d F Y');

        $time = Carbon::now()->format('H:i');

        $schoolService = new School;

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

        $subject = $responseSubject['error'] ? '' : $responseSubject['data']['name'] ?? '';

        $pageData = [
            'user' => $user,
            'task' => $task,
            'answers' => $answers,
            'userable' => $user['userable'],
            'date' => $date,
            'time' => $time,
            'subject' => $subject,
        ];

        $pdf = PDF::loadview('student.mini_assessment.exam.answer', $pageData)
            ->setPaper('a4', 'potrait');

        $taskGroup = $task['mini_assessment']['group'];

        $filename = $user['userable']['name'] . '-' . $taskGroup . '-' . $subject . '-' . $time . '.PDF';

        return $pdf->download($filename);
    }
    // End Print Pdf

    // Private Function
    private function getAnswer($taskId)
    {
        $taskService = new Task;

        $response = $taskService->answersMiniAssessment($taskId);
        $data = [];

        if ($response['error']) {
            return $data;
        }

        if (!$response['error']) {
            foreach ($response['data'] as $val) {
                $data[$val['mini_assessment_answer_id']] = [
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
