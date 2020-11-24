<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Services\AssessmentGroup as AssessmentGroupApi;
use App\Services\MiniAssessment as miniAssessmentApi;
use App\Services\School as SchoolApi;
use Carbon\Carbon;
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

        return view('teacher.subjects.index')
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

        $miniAssessmentApi = new miniAssessmentApi;
        $filterMA = [
            'filter[grade]' => $grade,
            'filter[group]' => $assessmentGroupId,
        ];
        $miniAssessments = $miniAssessmentApi->index($filterMA);

        return view('teacher.assessment.index')
            ->with('assessmentGroupId', $assessmentGroupId)
            ->with('assessmentGroup', $assessmentGroup)
            ->with('miniAssessments', $miniAssessments['data'])
            ->with('miniAssessmentsMeta', $miniAssessments['meta'])
            ->with('subject', $subjectDetail['data'])
            ->with('grade', $grade)
            ->with('message', 'Data success');
    }

    public function createMiniAssessment(Request $request, $assessmentGroupId, $subjectId, $grade)
    {
        $miniAssessmentApi = new miniAssessmentApi;
        $reqFile = [
            [
                'file_extension' => 'pdf',
                'file' => $request->file('pdf_file'),
                'file_name' => $request['pdf_name'],
            ],
        ];
        $dif = Carbon::now('UTC')->diffInHours(date('Y-m-d H:i:s'));
        $t = Carbon::now()->addHours($dif + 1);
        $payload = [
            'title' => $request['title'],
            'duration' => $request['duration'],
            'subject_id' => $subjectId,
            'grade' => $grade,
            'group' => $assessmentGroupId,
            'start_time' => json_encode($t),
            'expiry_time' => json_encode($t->addMinutes($duration)),
            'pdf_password' => $request['pdf_password'],
            'total_questions' => $request['total_questions'],
            'choices_number' => $request['choices_number'],
        ];
        $create = $miniAssessmentApi->create($reqFile, $payload);
        if ($create) {
            return redirect()->back()->with(['type' => 'success', 'message' => 'Data berhasil tersimpan!']);
        }

        return redirect()->back()->with(['type' => 'danger', 'message' => 'Data gagal tersimpan!']);
    }

    public function settingMiniAssessment(Request $request, $assessmentGroupId, $subjectId, $grade, $miniAssessmentId)
    {
        $miniAssessmentApi = new miniAssessmentApi;
        $miniAssessmentDetail = $miniAssessmentApi->detail($miniAssessmentId);
        $payload = [
            'title' => $miniAssessmentDetail['data']['title'],
            'duration' => $request['duration'],
            'subject_id' => $subjectId,
            'grade' => $grade,
            'group' => $assessmentGroupId,
            'start_time' => $miniAssessmentDetail['data']['start_time'],
            'expiry_time' => $miniAssessmentDetail['data']['expiry_time'],
            'pdf_password' => $request['pdf_password'],
            'total_questions' => $request['total_questions'],
            'choices_number' => $request['choices_number'],
        ];
        $update = $miniAssessmentApi->update($miniAssessmentId, $payload);
        if ($update) {
            return redirect()->back()->with(['type' => 'success', 'message' => 'Data berhasil diperbaharui!']);
        }

        return redirect()->back()->with(['type' => 'danger', 'message' => 'Data gagal diperbaharui!']);
    }
}
