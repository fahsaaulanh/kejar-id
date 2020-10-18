<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\MiniAssessment;
use App\Services\School;
use App\Services\Task;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use PDF;

class MiniAssessmentController extends Controller
{
    public function index()
    {
        $user = $this->request->session()->get('user', null);
        $task = $this->request->session()->get('task', null);

        if ($task !== null) {
            if (count($task['task']) > 0) {
                $subjectId = $task['subject_id'];

                return redirect("/student/mini_assessment/$subjectId/exam");
            }
        }

        if (!$user) {
            return redirect('/login');
        }

        return view('student.mini_assessment.subjects.index');
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
            $startTime = Carbon::parse($dataMA['start_time']);
            $endTime = Carbon::parse($dataMA['expiry_time']);

            $dataMA['duration'] = $startTime->diffInMinutes($endTime);
            $dataMA['start_fulldate'] = Carbon::parse($dataMA['start_time'])->format('Y-m-d H:i:s');
            $dataMA['expiry_fulldate'] = Carbon::parse($dataMA['expiry_time'])->format('Y-m-d H:i:s');
            $dataMA['start_date'] = Carbon::parse($dataMA['start_time'])->format('l, d F Y');
            $dataMA['start_time'] = Carbon::parse($dataMA['start_time'])->format('H.i');
            $dataMA['expiry_date'] = Carbon::parse($dataMA['expiry_time'])->format('l, d F Y');
            $dataMA['expiry_time'] = Carbon::parse($dataMA['expiry_time'])->format('H.i');

            $dataMA['random_char'] = Str::random(12);
            //

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
            return redirect('/student/mini_assessment');
        }

        if ($task['task_id'] === '') {
            return redirect('/student/mini_assessment');
        }

        $answers = $this->getAnswer($task['task_id']);
        $this->request->session()->put('answers', $answers);

        $pageData = [
            'user' => $user,
            'task' => $task,
            'answers' => $answers,
            'userable' => $user['userable'],
        ];

        return view('student.mini_assessment.exam.index', $pageData);
    }

    // API Function
    public function subjects()
    {
        $maService = new MiniAssessment;
        $schoolService = new School;
        $taskService = new Task;

        $schoolId = $this->request->input('school_id');
        $user = $this->request->session()->get('user', null);

        $grade = $this->getGrade();

        $filter = [
            'filter[grade]' => $grade,
            'filter[subject_id]' => 'a79374e3-f447-4b79-8ddb-435afa515d05',
        ];

        $response = $maService->index($filter);

        if (!$response['error']) {
            $dataCollect = collect($response['data']);
            $newDataUnique = $dataCollect->unique('subject_id');
            foreach ($newDataUnique as $key => $newData) {
                // GET Data Subject
                $responseSubject = $schoolService->subjectDetail($schoolId, 'a79374e3-f447-4b79-8ddb-435afa515d05');
                $newData['subject'] = $responseSubject['error'] ? '' : $responseSubject['data']['name'] ?? '';
                //
                // Get Data Tasks
                $filterTask = [
                    'per_page' => 99,
                    'filter[subject_id]' => $newData['subject_id'],
                    'filter[finished]' => 'true',
                ];
                $responseTask = $taskService->tasksMiniAssessment($user['userable']['id'], $filterTask);
                $newData['tasks'] = $responseTask['error'] ? [] : $responseTask['data'] ?? [];
                //

                $newStartDate = Carbon::parse($newData['start_time'])->format('l, d F Y');
                $newStartTime = Carbon::parse($newData['start_time'])->format('H.i');
                $newExpiryDate = Carbon::parse($newData['expiry_time'])->format('l, d F Y');
                $newExpiryTime = Carbon::parse($newData['expiry_time'])->format('H.i');
                $startTimeFullDate = Carbon::parse($newData['start_time'])->format('Y-m-d H:i:s');
                $expiryTimeFullDate = Carbon::parse($newData['expiry_time'])->format('Y-m-d H:i:s');
                $newData['start_date'] = $newStartDate;
                $newData['start_time'] = $newStartTime;
                $newData['expiry_date'] = $newExpiryDate;
                $newData['expiry_time'] = $newExpiryTime;
                $newData['start_fulldate'] = $startTimeFullDate;
                $newData['expiry_fulldate'] = $expiryTimeFullDate;

                $newDataUnique[$key] = $newData;
            }

            $response['data'] = $newDataUnique->values();
        }

        return $response;
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

        $response = $taskService->finishMiniAssessment($task['task_id']);

        if (!$response['error']) {
            $this->request->session()->remove('task');
            $this->request->session()->remove('answers');

            return $response;
        }

        return $response;
    }
    // End Of API Function

    // Print Pdf

    public function print()
    {
        $date = Carbon::now()->format('d F Y');

        $time = Carbon::now()->format('H:i');

        $schoolService = new School;

        $task = $this->request->session()->get('task');
        $answers = $this->getAnswer($task['task_id']);
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

        return $pdf->download($user['userable']['name'] . ' ' . $taskGroup . ' ' . $subject . ' ' . $time . '.pdf');
    }
    // End Print Pdf

    // Private Function
    private function getAnswer($taskId)
    {
        $taskService = new Task;

        $response = $taskService->answersMiniAssessment($taskId);
        $data = [];

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
