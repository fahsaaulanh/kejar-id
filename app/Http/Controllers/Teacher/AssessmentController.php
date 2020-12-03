<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Services\Assessment as AssessmentApi;
use App\Services\AssessmentGroup as AssessmentGroupApi;
use App\Services\Question as QuestionApi;
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

        $assessmentApi = new AssessmentApi;
        $filterMA = [
            'filter[grade]' => $grade,
            'filter[group]' => $assessmentGroupId,
            'filter[subject_id]' => $subjectId,
        ];
        $assessments = $assessmentApi->index($filterMA);
        $dataAssessment = ($assessments['data'] ?? []);

        $dataQuestion = (count($dataAssessment) > 0 ? $assessmentApi->questions($dataAssessment[0]['id']) : null);
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
        $assessmentApi = new AssessmentApi;
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
        $create = $assessmentApi->create($reqFile, $payload);
        if ($create) {
            return redirect()->back()->with(['type' => 'success', 'message' => 'Data berhasil tersimpan!']);
        }

        return redirect()->back()->with(['type' => 'danger', 'message' => 'Data gagal tersimpan!']);
    }

    public function settingMiniAssessment(Request $request, $assessmentGroupId, $subjectId, $grade, $assessmentId)
    {
        $assessmentApi = new AssessmentApi;
        $assessmentDetail = $assessmentApi->detail($assessmentId);
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
        $update = $assessmentApi->update($assessmentId, $payload);
        if ($update) {
            return redirect()->back()->with(['type' => 'success', 'message' => 'Data berhasil diperbaharui!']);
        }

        return redirect()->back()->with(['type' => 'danger', 'message' => 'Data gagal diperbaharui!']);
    }

    public function viewQuestion($id)
    {
        $assessmentApi = new AssessmentApi;
        $question = $assessmentApi->questions($id);
     
        $detail = $assessmentApi->detail($id);
        $data = [];
        $data['detail'] = $detail['data'];
        $data['detail']['validated_by_name'] = '';
        $data['detail']['countAnswer'] = collect($question['data'])->where('answer', '')->count();

        $UserApi = new UserApi;
        $user = $UserApi->detailUser($data['detail']['created_by']);
        $teacher = $UserApi->detailTeacher($user['data']['userable_id']);
        $data['detail']['created_by_name'] = $teacher['data']['name'];

        if ($data['detail']['validated_by']) {
            $user = $UserApi->detailUser($data['detail']['validated_by']);
            $teacher = $UserApi->detailTeacher($user['data']['userable_id']);
            $data['detail']['validated_by_name'] = $teacher['data']['name'];
        }

        $choices1 = $this->choicesHtml($question['data'], 1);

        $choices2 = $this->choicesHtml($question['data'], 2);

        $data['choicesTab1'] = $choices1;
        $data['choicesTab2'] = $choices2;

        return response()->json($data);
    }

    public function choicesHtml($questions, $tab)
    {
        $divider = (float) (count($questions) / 2);
        $size = ceil($divider);

        $chunkQuestion = array_chunk($questions, $size);

        $view = '';

        $view2 = '';

        $no = 1;

        foreach ($chunkQuestion[0] as $question) {
            $view .= '<div class="row px-4 mt-4">';
            $view .= '<div class="pts-number">' . $no . '</div>';
            $view .= '<div class="col">';
            $view .= ' <div class="row">';

            $qId = $question['id'];

            $countQ = count($question['choices']);

            foreach ($question['choices'] as $key => $c) {
                if ($c === $question['answer']) {
                    $view .= '<div class="mb-2 mb-md-0 mb-lg-0 mb-xl-0 pts-choice active"\
                        onclick="onClickAnswerPG(\'' . $key . '\',\'' . $qId . '\',\'' . $c . '\',\'' . $countQ . '\')"\
                        id="pts-choice-' . $qId . '-' . $key . '">';
                } else {
                    $view .= '<div class="mb-2 mb-md-0 mb-lg-0 mb-xl-0 pts-choice"\
                        onclick="onClickAnswerPG(\'' . $key . '\',\'' . $qId . '\',\'' . $c . '\',\'' . $countQ . '\')"\
                        id="pts-choice-' . $qId . '-' . $key . '">';
                }

                $view .= '<span class="caption">' . $c . '</span></div>';
            }

            $view .= '<div id="pts-choice-load-' . $qId . '" style="display:none"\
                    class="mb-2 mb-md-0 mb-lg-0 mb-xl-0 pl-4 pt-1 spin-load">';
            $view .= '<div class="spinner-border" role="status">';
            $view .= ' <span class="sr-only">Loading...</span>';
            $view .= '</div>';
            $view .= '</div>';

            $view .= '<div id="pts-choice-success-' . $qId . '"  style="display:none"\
                    class="mb-2 mb-md-0 mb-lg-0 mb-xl-0 pl-4 font-24">';
            $view .= '<i class="kejar-soal-benar"></i></div>';

            $view .= '</div>';
            $view .= '</div>';
            $view .= '</div>';
            $no++;
        }

        foreach ($chunkQuestion[1] as $question) {
            $view2 .= '<div class="row px-4 mt-4">';
            $view2 .= '<div class="pts-number">' . $no . '</div>';
            $view2 .= '<div class="col">';
            $view2 .= ' <div class="row">';

            $qId = $question['id'];

            $countQ = count($question['choices']);

            foreach ($question['choices'] as $key => $c) {
                if ($c === $question['answer']) {
                    $view2 .= '<div class="mb-2 mb-md-0 mb-lg-0 mb-xl-0 pts-choice active"\
                        onclick="onClickAnswerPG(\'' . $key . '\',\'' . $qId . '\',\'' . $c . '\',\'' . $countQ . '\')"\
                        id="pts-choice-' . $qId . '-' . $key . '">';
                } else {
                    $view2 .= '<div class="mb-2 mb-md-0 mb-lg-0 mb-xl-0 pts-choice"\
                        onclick="onClickAnswerPG(\'' . $key . '\',\'' . $qId . '\',\'' . $c . '\',\'' . $countQ . '\')"\
                        id="pts-choice-' . $qId . '-' . $key . '">';
                }

                $view2 .= '<span class="caption">' . $c . '</span></div>';
            }

            $view2 .= '<div id="pts-choice-load-' . $qId . '" style="display:none"\
                    class="mb-2 mb-md-0 mb-lg-0 mb-xl-0 pl-4 pt-1 spin-load">';
            $view2 .= '<div class="spinner-border" role="status">';
            $view2 .= ' <span class="sr-only">Loading...</span>';
            $view2 .= '</div>';
            $view2 .= '</div>';

            $view2 .= '<div id="pts-choice-success-' . $qId . '"  style="display:none"\
                    class="mb-2 mb-md-0 mb-lg-0 mb-xl-0 pl-4 font-24">';
            $view2 .= '<i class="kejar-soal-benar"></i></div>';

            $view2 .= '</div>';
            $view2 .= '</div>';
            $view2 .= '</div>';
            $no++;
        }

        if ($tab === 1) {
            return $view;
        }

        return $view2;
    }

    public function checkQuestion($id)
    {
        $assessmentApi = new AssessmentApi;

        $question = $assessmentApi->questions($id);
     
        $detail = $assessmentApi->detail($id);

        $data = [];
        $data['detail'] = $detail['data'];
        $data['detail']['validated_by_name'] = '';
        $data['detail']['countAnswer'] = collect($question['data'])->where('answer', '')->count();

        $UserApi = new UserApi;
        $user = $UserApi->detailUser($data['detail']['created_by']);
        $teacher = $UserApi->detailTeacher($user['data']['userable_id']);
        $data['detail']['created_by_name'] = $teacher['data']['name'];

        if ($data['detail']['validated_by']) {
            $user = $UserApi->detailUser($data['detail']['validated_by']);
            $teacher = $UserApi->detailTeacher($user['data']['userable_id']);
            $data['detail']['validated_by_name'] = $teacher['data']['name'];
        }

        return response()->json($data);
    }

    public function updateQuestion()
    {
        $questionService = new QuestionApi;

        $answer = $this->request->input('answer');
        $questionId = $this->request->input('questionId');

        $questionDetail = $questionService->getDetail($questionId);

        $payload = [
            'answer' => $answer,
            'created_by' => $questionDetail['data']['created_by'],
            'question' => $questionDetail['data']['question'],
            'type' => $questionDetail['data']['type'],
        ];

        return $questionService->update($questionId, $payload);
    }

    public function validationQuestion()
    {
        $assessmentApi = new AssessmentApi;

        $assessmentId = $this->request->input('idAssessment');

        $payload = [
            'validation' => true,
        ];

        $validation = $assessmentApi->update($assessmentId, $payload);
     
        $data = [];
        $data['detail'] = $validation['data'];

        $UserApi = new UserApi;
        $user = $UserApi->detailUser($data['detail']['created_by']);
        $teacher = $UserApi->detailTeacher($user['data']['userable_id']);
        $data['detail']['created_by_name'] = $teacher['data']['name'];

        $user = $UserApi->detailUser($data['detail']['validated_by']);
        $teacher = $UserApi->detailTeacher($user['data']['userable_id']);
        $data['detail']['validated_by_name'] = $teacher['data']['name'];

        return response()->json($data);
    }

    public function dateFormat($val, $format = 'Y/m/d H:i:s')
    {
        $date = date_create($val);

        return date_format($date, $format);
    }
}
