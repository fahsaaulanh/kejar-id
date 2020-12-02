<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Services\Assessment as AssessmentApi;
use App\Services\AssessmentGroup as AssessmentGroupApi;
use App\Services\School as SchoolApi;
use App\Services\User as UserApi;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function assessmentGroups($val, $type = 'title')
    {
        $AssessmentGroupApi = new AssessmentGroupApi;
        $detail = $AssessmentGroupApi->detail($val);
        $ret = '';

        if ($detail['status'] === 200) {
            $data = $detail['data'];
            $types = [
                'title' => $data['title'],
                'value' => $data['id'],
                'header' => $data['title'],
            ];
            $ret = $types[$type];
        }

        return $ret;
    }

    public function subjects(Request $req, $assessmentGroupId)
    {
        $assessmentGroupApi = new AssessmentGroupApi;
        $schoolId = session()->get('user.userable.school_id');
        $assessmentGroup = $assessmentGroupApi->detail($assessmentGroupId);
        $schoolApi = new SchoolApi;
        $filter = [
            'page' => ($req->page ?? 1),
            'filter[name]' => ($req->name ?? ''),
            'per_page' => 20,
        ];
        $subjects = $schoolApi->subjectIndex($schoolId, $filter);
        if (!isset($subjects['data'])) {
            $subjects['data'] = [];
        }

        if (!isset($subjects['meta'])) {
            $subjects['meta'] = [];
        }

        return view('teacher.subject_teacher.subjects.index')
            ->with('assessmentGroupId', $assessmentGroupId)
            ->with('assessmentGroup', $assessmentGroup['data']['title'])
            ->with('subjects', $subjects['data'])
            ->with('subjectMeta', $subjects['meta']);
    }

    public function assessment($assessmentGroupId, $subjectId, $grade)
    {
        $schoolId = session()->get('user.userable.school_id');
        $assessmentGroup = $this->assessmentGroups($assessmentGroupId);
        $schoolApi = new SchoolApi;

        $subjectDetail = $schoolApi->subjectDetail($schoolId, $subjectId);

        $AssessmentApi = new AssessmentApi;
        $filterMA = [
            'filter[grade]' => $grade,
            'filter[group]' => $assessmentGroupId,
            'filter[subject_id]' => $subjectId,
        ];
        $assessments = $AssessmentApi->index($filterMA);
        $dataAssessment = ($assessments['data'] ?? []);

        $dataQuestion = (count($dataAssessment) > 0 ? $AssessmentApi->questions($dataAssessment[0]['id']) : null);
        $dataChoices = ($dataQuestion['data'] !== null ? $dataQuestion['data'][0]['choices'] : []);

        return view('teacher.subject_teacher.assessment.index')
            ->with('assessmentGroupId', $assessmentGroupId)
            ->with('assessmentGroup', $assessmentGroup)
            ->with('assessments', $dataAssessment)
            ->with('question', count($dataQuestion['data'] ?? []))
            ->with('choices', count($dataChoices))
            ->with('assessmentsMeta', $assessments['meta'])
            ->with('subject', $subjectDetail['data'])
            ->with('grade', $grade)
            ->with('type', ($dataAssessment[0]['type'] ?? ''))
            ->with('message', 'Data success');
    }

    public function createMiniAssessment(Request $request, $assessmentGroupId, $subjectId, $grade)
    {
        $AssessmentApi = new AssessmentApi;
        $reqFile = [
            [
                'file_extension' => 'pdf',
                'file' => $request->file('pdf_file'),
                'file_name' => $request['pdf_name'],
            ],
        ];
        $payload = [
            'duration' => $request['duration'],
            'subject_id' => $subjectId,
            'grade' => $grade,
            'assessment_group_id' => $assessmentGroupId,
            'type' => $request['type'],
            'pdf_password' => $request['pdf_password'],
            'total_question' => $request['total_question'],
            'total_choices' => $request['total_choices'],
        ];
        $create = $AssessmentApi->create($reqFile, $payload);
        if ($create) {
            return redirect()->back()->with(['type' => 'success', 'message' => 'Data berhasil tersimpan!']);
        }

        return redirect()->back()->with(['type' => 'danger', 'message' => 'Data gagal tersimpan!']);
    }

    public function settingMiniAssessment(Request $request, $assessmentGroupId, $subjectId, $grade, $assessmentId)
    {
        $AssessmentApi = new AssessmentApi;
        $assessmentDetail = $AssessmentApi->detail($assessmentId);
        $payload = [
            'duration' => $request['duration'],
            'subject_id' => $subjectId,
            'grade' => $grade,
            'assessment_group_id' => $assessmentGroupId,
            'type' => $assessmentDetail['data']['type'],
            'pdf_password' => $request['pdf_password'],
            'total_question' => $request['total_question'],
            'total_choices' => $request['total_choices'],
        ];
        $update = $AssessmentApi->update($assessmentId, $payload);
        if ($update) {
            return redirect()->back()->with(['type' => 'success', 'message' => 'Data berhasil diperbaharui!']);
        }

        return redirect()->back()->with(['type' => 'danger', 'message' => 'Data gagal diperbaharui!']);
    }

    public function viewMini($id)
    {
        $AssessmentApi = new AssessmentApi;
        $detail = $AssessmentApi->detail($id);
        $data = [];
        $data['detail'] = $detail['data'];
        $data['detail']['created'] = '';
        if ($data['detail']['validated']) {
            $UserApi = new UserApi;
            $teacher = $UserApi->detailTeacher($data['detail']['validated_by']);
            $data['detail']['created'] = $teacher['data']['name'];
        }

        $data['time'] = $this->dateFormat($detail['data']['start_time'], 'd M Y') .
            ', ' . $this->dateFormat($detail['data']['start_time'], 'H.i') .
            ' - ' . $this->dateFormat($detail['data']['expiry_time'], 'H.i');

        // $answersAPI = $AssessmentApi->answers($id);

        $total_question = 50;
        $total_choices = 5;


        $choices1 = $this->choicesHtml($total_question, $total_choices, $id, 1);

        $choices2 = $this->choicesHtml($total_question, $total_choices, $id, 2);


        // if ($answersAPI['data']) {

        // }

        $data['choicesTab1'] = $choices1;
        $data['choicesTab2'] = $choices2;

        return response()->json($data);
    }

    public function choicesHtml($total, $number, $id, $tab)
    {
        $divider = (float) ($total / 2);
        $divider = ceil($divider);

        $view = '';
        if ($tab === 1) {
            for ($i = 1; $i <= $divider; $i++) {
                $view .= '<div class="row px-4 mt-4">';
                $view .= '<div class="pts-number">' . $i . '</div>';
                $view .= '<div class="col">';
                $view .= ' <div class="row">';

                for ($c = 1; $c <= $number; $c++) {
                    $view .= '<div class="mb-2 mb-md-0 mb-lg-0 mb-xl-0 pts-choice"\
                    onclick="onClickAnswerPG(\'' . $i . '\',\'' . $c . '\',\'' . $id . '\',\'' . $number . '\')"\
                    id="pts-choice-' . $i . '-' . $c . '">';
                    $view .= '<span class="caption">' . chr(64 + $c) . '</span></div>';
                }

                $view .= '<div id="pts-choice-load-' . $i . '" style="display:none"\
                class="mb-2 mb-md-0 mb-lg-0 mb-xl-0 pl-4 pt-1 spin-load">';
                $view .= '<div class="spinner-border" role="status">';
                $view .= ' <span class="sr-only">Loading...</span>';
                $view .= '</div>';
                $view .= '</div>';

                $view .= '<div id="pts-choice-success-' . $i . '"  style="display:none"\
                class="mb-2 mb-md-0 mb-lg-0 mb-xl-0 pl-4 font-24">';
                $view .= '<i class="kejar-soal-benar"></i></div>';

                $view .= '</div>';
                $view .= '</div>';
                $view .= '</div>';
            }

            return $view;
        }

        for ($i = $divider + 1; $i <= $total; $i++) {
            $view .= '<div class="row px-4 mt-4">';
            $view .= '<div class="pts-number">' . $i . '</div>';
            $view .= '<div class="col">';
            $view .= ' <div class="row">';

            for ($c = 1; $c <= $number; $c++) {
                $view .= '<div class="mb-2 mb-md-0 mb-lg-0 mb-xl-0 pts-choice"\
                onclick="onClickAnswerPG(\'' . $i . '\',\'' . $c . '\',\'' . $id . '\',\'' . $number . '\')"\
                id="pts-choice-' . $i . '-' . $c . '">';
                $view .= '<span class="caption">' . chr(64 + $c) . '</span></div>';
            }

            $view .= '<div id="pts-choice-load-' . $i . '" style="display:none"\
            class="mb-2 mb-md-0 mb-lg-0 mb-xl-0 pl-4 pt-1 spin-load">';
            $view .= '<div class="spinner-border" role="status">';
            $view .= ' <span class="sr-only">Loading...</span>';
            $view .= '</div>';
            $view .= '</div>';

            $view .= '<div id="pts-choice-success-' . $i . '" style="display:none"\
            class="mb-2 mb-md-0 mb-lg-0 mb-xl-0 pl-4 font-24">';
            $view .= '<i class="kejar-soal-benar"></i></div>';

            $view .= '</div>';
            $view .= '</div>';
            $view .= '</div>';
        }

        return $view;
    }

    public function dateFormat($val, $format = 'Y/m/d H:i:s')
    {
        $date = date_create($val);

        return date_format($date, $format);
    }
}
