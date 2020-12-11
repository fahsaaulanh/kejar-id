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

        $startAt = Carbon::parse($schedule['data']['schedule']['start_time']);
        $endAt = Carbon::parse($schedule['data']['schedule']['finish_time']);

        if ($schedule['data']['task'] !== null) {
            return redirect()->back()->with(['message' => 'Kamu telah mengerjakan penilaian ini.']);
        }

        if (Carbon::now() < $startAt) {
            return redirect()->back()->with(['message' => 'Jadwal penilaian belum dimulai.']);
        }

        if (Carbon::now() > $endAt) {
            return redirect()->back()->with(['message' => 'Jadwal penilaian sudah berakhir.']);
        }

        $now = Carbon::now()->format('Y-m-d H:i:s');

        $pageData = [
            'assessment' => $schedule['data'],
            'now' => $now,
            'assessmentGroupId' => $assessment_group_id,
        ];

        return view('student.onboarding_exam.index', $pageData);
    }

    public function proceed($assessment_group_id, $schedule_id)
    {
        $assessment_group_id;
        $taskService = new Task;
        $assessmentService = new Assessment;

        $responseAssessment = $assessmentService->detail($schedule_id);
        $responseQuestions = $taskService->questionsAssessment($schedule_id);

        if ($responseAssessment['error']) {
            return redirect()->back()->with(['message' => 'Data Penilaian tidak ditemukan']);
        }

        $questions = $responseQuestions['data'];
        $assessment = $responseAssessment['data'];
        $assessmentGroupId = $assessment['assessment_group_id'];
        $subjectId = $assessment['subject_id'];

        $responseTask = $taskService->startAssessment($schedule_id);

        if ($responseTask['error']) {
            return redirect()->back()->with([
                'message' => 'Data Penilaian tidak ditemukan, tidak bisa memulai Penilaian',
            ]);
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

        if ($schedules['data'] === null) {
            $view = `
                <div class="alert alert-primary mt-2">
                    <h6>Tidak ada data penilaian.</h6>
                </div>
            `;

            return response()->json($view);
        }

        $now = Carbon::now();

        $view = '';
        foreach ($schedules['data'] as $schedule) {
            $icon = $schedule['task'] === null ? 'kejar-mapel' : 'kejar-sudah-dikerjakan';
            $startAt = Carbon::parse($schedule['schedule']['start_time'])->format('d M Y, H:i');
            $endAt = Carbon::parse($schedule['schedule']['finish_time'])->format('d M Y, H:i');

            // if true then user can do assessment
            $startAtStatus = $now > $schedule['schedule']['start_time'] ? 'true' : 'false';
            // if true then user can't do assessment
            $endAtStatus = $now > $schedule['schedule']['finish_time'] ? 'true' : 'false';

            $metaRow = 'start-status="'.$startAtStatus.'" end-status="'.$endAtStatus.'" ';

            $metaRow .= 'task-status="'.$icon.'" data-id="'. $schedule['schedule']['id'] .'"';

            $view .= '<div onclick="goOnboarding(this)" '.$metaRow.' class="row m-0 pt-4">';
                $view .= '<div class="row m-0 btn-accordion-subject w-100" role="button">';
                    $view .='<div class="row m-0 justify-content-between w-100 subject-item-assessment">';
                        $view .= '<div class="row m-0" onclick="">';
                            $view .='<div class="col-md-1 p-0">';
                                    $view .='<i class="'. $icon .'"></i>';
                            $view .='</div>';
                            $view .='<div class="row m-0 pl-4 flex-column">';
                                $view .= '<div id="mapel">';
                                    $view .= '<h4>'. $schedule['subject']['name'] .'</h4>';
                                $view .= '</div>';
                                $view .= '<div class="pt-2">';
                                  $view .= '<h6 class="text-grey-3"> Dimulai pada '. $startAt. ' </h6>';
                                $view .= '</div>';
                                $view .= '<div class="pt-2">';
                                  $view .= '<h6 class="text-grey-3"> Berakhir pada '. $endAt . ' </h6>';
                                $view .= '</div>';
                            $view .='</div>';
                            $view .= '<div class="col-md-6 mt-2 mt-md-0 mt-lg-0 align-items-end">';
                                $view .= `<div class="row justify-content-start justify-content-md-end
                                justify-content-lg-end">`;
                                $view .= '</div>';
                            $view .= '</div>';
                            $view .='<div class="icon">';
                                $view .='<i class="kejar-right"></i>';
                            $view .='</div>';
                        $view .= '</div>';
                    $view .='</div>';
                $view .= '</div>';
            $view .= '</div>';
        }

        return response()->json($view);
    }

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
}
