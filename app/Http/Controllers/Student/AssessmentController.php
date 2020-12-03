<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Me;
use Carbon\Carbon;

class AssessmentController extends Controller
{
    public function schedules($assessmentGroupId)
    {
        $assessmentGroupId;

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

        if ($schedule['data']['task'] !== null) {
            return redirect()->back();
        }

        $now = Carbon::now()->format('Y-m-d H:i:s');

        $pageData = [
            'assessment' => $schedule['data'],
            'now' => $now,
            'assessmentGroupId' => $assessment_group_id,
        ];

        return view('student.onboarding_exam.index', $pageData);
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

        if ($schedules['data'] === null) {
            return false;
        }

        $now = Carbon::now();

        $view = '';
        foreach ($schedules['data'] as $schedule) {
            $icon = $schedule['task'] === null ? 'kejar-mapel' : 'kejar-sudah-mengerjakan';
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
                    $view .='<div class="row m-0 justify-content-between w-100">';
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
                        $view .= '</div>';
                        $view .='<div>';
                            $view .='<i class="kejar-right"></i>';
                        $view .='</div>';
                    $view .='</div>';
                $view .= '</div>';
            $view .= '</div>';
        }

        return response()->json($view);
    }
}
