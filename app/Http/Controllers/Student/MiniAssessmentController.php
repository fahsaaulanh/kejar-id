<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\MiniAssessment;
use App\Services\School;
use App\Services\Task;
use Carbon\Carbon;

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
            $dataMA['start_date'] = Carbon::parse($dataMA['start_time'])->format('l, d F Y');
            $dataMA['start_time'] = Carbon::parse($dataMA['start_time'])->format('h.i');
            $dataMA['expiry_date'] = Carbon::parse($dataMA['expiry_time'])->format('l, d F Y');
            $dataMA['expiry_time'] = Carbon::parse($dataMA['expiry_time'])->format('h.i');
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
        $answers = $this->getAnswer($task['task_id']);

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

        $schoolId = $this->request->input('school_id');

        $grade = $this->getGrade();

        $filter = [
            'filter[grade]' => $grade,
        ];

        $response = $maService->index($filter);

        if (!$response['error']) {
            $dataCollect = collect($response['data']);
            $newDataUnique = $dataCollect->unique('subject_id');

            foreach ($newDataUnique as $key => $newData) {
                // GET Data Subject
                $responseSubject = $schoolService->subjectDetail($schoolId, $newData['subject_id']);
                $newData['subject'] = $responseSubject['error'] ? '' : $responseSubject['data']['name'];
                //

                $newStartDate = Carbon::parse($newData['start_time'])->format('l, d F Y');
                $newStartTime = Carbon::parse($newData['start_time'])->format('h.i');
                $newExpiryDate = Carbon::parse($newData['start_time'])->format('l, d F Y');
                $newExpiryTime = Carbon::parse($newData['start_time'])->format('h.i');
                $newData['start_date'] = $newStartDate;
                $newData['start_time'] = $newStartTime;
                $newData['expiry_date'] = $newExpiryDate;
                $newData['expiry_time'] = $newExpiryTime;

                $newDataUnique[$key] = $newData;
            }

            $response['data'] = $newDataUnique->values();
        }

        return $response;
    }

    public function setAnswer()
    {
        $taskService = new Task;

        $answerId = $this->request->input('answer_id');

        $payload = [
            'answer' => $this->request->input('answer'),
        ];

        $task = $this->request->session()->get('task');

        $response = $taskService->setAnswerMiniAssessment($task['task_id'], $answerId, $payload);

        if (!$response['error']) {
            return $response;
        }

        return $response;
    }

    public function finish()
    {
        $taskService = new Task;

        $task = $this->request->session()->get('task');

        $response = $taskService->finishMiniAssessment($task['task_id']);

        if (!$response['error']) {
            $this->request->session()->remove('task');

            return $response;
        }

        return $response;
    }
    // End Of API Function

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
