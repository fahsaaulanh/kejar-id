<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Assessment;
use App\Services\Me;
use App\Services\Task;
use Carbon\Carbon;

class AssessmentController extends Controller
{
    public function schedules($assessmentGroupId)
    {
        $user = $this->request->session()->get('user', null);

        if (!$user) {
            return redirect('/login');
        }

        $now = Carbon::now()->format('Y-m-d H:i:s');

        $data = [
            'now' => $now,
            'assessmentGroupId' => $assessmentGroupId,
        ];

        return view('student.subjects.index', $data);
    }

    public function detail($assessment_group_id, $schedule_id)
    {
        $meService = new Me;

        $schedule = $meService->assessmentScheduleDetail($schedule_id);

        $now = Carbon::now()->format('Y-m-d H:i:s');

        $pageData = [
            'assessment' => $schedule['data'],
            'now' => $now,
            'assessmentGroupId' => $assessment_group_id,
        ];

        return view('student.onboarding_exam.index', $pageData);
    }

    public function proceed($assessment_group_id, $assessment_id, $schedule_id)
    {
        $assessment_group_id;
        $taskService = new Task;
        $assessmentService = new Assessment;
        $meService = new Me;

        $schedule = $meService->assessmentScheduleDetail($schedule_id);
        $responseAssessment = $assessmentService->detail($assessment_id);

        if ($responseAssessment['error']) {
            return redirect()->back()->with(['message' => 'Data Penilaian tidak ditemukan']);
        }

        $assessment = $responseAssessment['data'];
        $assessmentGroupId = $assessment['assessment_group_id'];
        $subjectId = $assessment['subject_id'];

        $responseTask = $taskService->startAssessment($assessment_id);

        if ($responseTask['error']) {
            return redirect()->back()->with([
                'message' => 'Data Penilaian tidak ditemukan, tidak bisa memulai Penilaian',
            ]);
        }

        $task = $responseTask['data'];

        $taskAnswer = $this->getAnswer($task['id']);

        $questions = $taskAnswer['questions'];
        $answers = $taskAnswer['answers'];

        $addMinutes = $assessment['duration'];
        $endTime = Carbon::now()->addMinutes($addMinutes)->format('Y-m-d H:i:s');

        $assessment['end_time'] = $endTime;
        $assessment['questions'] = $questions;

        $tasksSession = [
            'subject_id' => $assessment['subject_id'],
            'assessment' => $assessment,
            'schedule' => $schedule['data'],
            'task_id' => $responseTask['data']['id'] ?? '',
            'task' => $responseTask['data'] ?? [],
            'answers' => $answers,
        ];

        $this->request->session()->put('task', $tasksSession);

        return redirect("/student/assessment/$assessmentGroupId/subjects/$subjectId/exam");
    }

    public function getSchedules()
    {
        $this->request->validate([
            'assessment_group_id' => 'required',
        ]);

        $meService = new Me;
        $assessmentGroupId = $this->request->input('assessment_group_id');

        $schedules = $meService->getAssessmentSchedules(
            [
                'filter[assessment_group_id]' => $assessmentGroupId,
            ],
        );

        if ($schedules['error']) {
            return false;
        }

        if (!$schedules['data']) {
            $view = '<div class="alert alert-primary mt-2">
                        <h6>Tidak ada data penilaian.</h6>
                    </div>';

            return response()->json($view);
        }

        $now = Carbon::now()->format('Y-m-d H:i:s');

        $view = '';
        foreach ($schedules['data'] as $schedule) {
            $statusTask = $schedule['schedule']['status_task'];

            $startAt = $schedule['schedule']['start_time'] === null ? null : Carbon::parse(
                $schedule['schedule']['start_time'],
            )->format('d M Y, H:i');

            $endAt = $schedule['schedule']['finish_time'] === null ? null : Carbon::parse(
                $schedule['schedule']['finish_time'],
            )->format('d M Y, H:i');

            $startAtStatus = 'null';
            $endAtStatus = 'null';

            $start_time = Carbon::parse($schedule['schedule']['start_time'])->format('Y-m-d H:i:s');
            $finish_time = Carbon::parse($schedule['schedule']['finish_time'])->format('Y-m-d H:i:s');

            if ($startAt !== null) {
                $startAtStatus = $now > $start_time ? 'true' : 'false';
            }

            if ($endAt !== null) {
                $endAtStatus = $now < $finish_time ? 'true' : 'false';
            }

            $metaRow = 'start-status="' . $startAtStatus . '" end-status="' . $endAtStatus . '" ';

            $icon = 'kejar-mapel';
            if ($statusTask === 'Undone') {
                $metaRow .= 'task-status="' . $statusTask . '" data-id="' . $schedule['schedule']['id'] . '"';
                if ($startAtStatus === 'false' || $endAtStatus === 'false') {
                    $view .= '<div onclick="goOnboarding(this)" ' .
                        $metaRow . ' class="row m-0 pt-4 card-mapel-assessment over">';
                } else {
                    $view .= '<div onclick="goOnboarding(this)" ' .
                    $metaRow . ' class="row m-0 pt-4 card-mapel-assessment">';
                }
            } elseif ($statusTask === 'Ongoing') {
                $metaRow .= 'task-status="' . $statusTask . '" data-id="' . $schedule['schedule']['id'] . '"';
                $view .= '<div onclick="goOnboarding(this)" ' .
                $metaRow . ' class="row m-0 pt-4 card-mapel-assessment">';
            } elseif ($statusTask === 'Done') {
                $icon = 'kejar-sudah-dikerjakan-outline';
                $metaRow .= 'task-status="' . $statusTask . '" data-id="' . $schedule['schedule']['id'] . '"';

                $view .= '<div onclick="goOnboarding(this)" ' .
                $metaRow . ' class="row m-0 pt-4 card-mapel-assessment done">';
            }

            $view .= '<div class="row m-0 btn-accordion-subject w-100" role="button">';
                $view .= '<div class="row m-0 justify-content-between w-100">';
                    $view .= '<div class="row m-0" onclick="">';
                        $view .= '<div class="p-0 pt-1">';
                            $view .= '<i class="' . $icon . '"></i>';
                        $view .= '</div>';

                        $view .= '<div class="row m-0 pl-4 flex-column">';
                            $view .= '<div id="mapel">';
                                $view .= '<h4>' . $schedule['subject']['name'] . '</h4>';
                            $view .= '</div>';

            if ($startAt !== null) {
                $view .= '<div class="pt-2">';
                    $view .= '<h6 class="text-grey-3"> Dimulai pada ' . $startAt . ' </h6>';
                $view .= '</div>';
            }

            if ($endAt !== null) {
                $view .= '<div class="pt-2">';
                    $view .= '<h6 class="text-grey-3"> Berakhir pada ' . $endAt . ' </h6>';
                $view .= '</div>';
            }

                            $view .= '</div>';
                            $view .= '<div class="col-md-6 mt-2 mt-md-0 mt-lg-0 align-items-end">';
                                $view .= `<div class="row justify-content-start justify-content-md-end
                                                    justify-content-lg-end">`;
                                $view .= '</div>';
                            $view .= '</div>';
                            $view .= '<div class="icon">';
                                $view .= '<i class="kejar-right"></i>';
                            $view .= '</div>';
                        $view .= '</div>';
                    $view .= '</div>';
                $view .= '</div>';
            $view .= '</div>';
        }

        return response()->json($view);
    }

    public function getQuestions()
    {
        $task = $this->request->session()->get('task');
        $answers = $this->getAnswer($task['task_id'])['answers'];

        $this->request->session()->put('answers', $answers);
        $questions = $task['assessment']['questions'];

        return response()->json([
            'questions' => $questions,
            'answers' => $answers,
        ]);
    }

    public function editNote()
    {
        $assessmentService = new Assessment;

        $task = $this->request->session()->get('task');

        $note = $this->request->input('noteStudent');

        $payloads = [
            'note' => $note,
        ];

        return $assessmentService->updateNote($task['schedule']['schedule']['id'], $payloads);
    }

    // Private Function
    private function getAnswer($taskId)
    {
        $taskService = new Task;

        $response = $taskService->answersAssessment($taskId);
        $data = [];
        $data['questions'] = [];
        $data['answers'] = [];

        if ($response['error']) {
            return $data;
        }

        if (!$response['error']) {
            foreach ($response['data'] as $key => $val) {
                $data['questions'][$key] = [
                    'id' => $val['question_id'],
                    'choices' => $val['choices'],
                    'question' => $val['question'],
                ];

                $data['answers'][$val['question_id']] = [
                    'id' => $val['id'],
                    'answer' => $val['answer'],
                ];
            }
        }

        return $data;
    }
}
