<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Services\Assessment as AssessmentApi;
use App\Services\AssessmentGroup as AssessmentGroupApi;
use App\Services\Batch as BatchApi;
use App\Services\Me as MeApi;
use App\Services\Question as QuestionApi;
use App\Services\Report as ReportApi;
use App\Services\Schedule as ScheduleApi;
use App\Services\School as SchoolApi;
use App\Services\StudentCounselor as StudentCounselorApi;
use App\Services\StudentGroup as StudentGroupApi;
use App\Services\Task as TaskApi;
use App\Services\User as UserApi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Throwable;

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

    private function teacherType($val)
    {
        if ($val === 'subject-teacher') {
            $val = 'subject_teacher';
        } elseif ($val === 'student-counselor') {
            $val = 'student_counselor';
        }

        return $val;
    }

    public function subjects(Request $req, $teacherType, $assessmentGroupId)
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

        return view('teacher.' . $this->teacherType($teacherType) . '.subjects.index')
            ->with('assessmentGroupId', $assessmentGroupId)
            ->with('teacherType', $teacherType)
            ->with('assessmentGroup', $assessmentGroup['data']['title'])
            ->with('subjects', $subjects['data'])
            ->with('subjectMeta', $subjects['meta']);
    }

    public function studentGroup($teacherType, $assessmentGroupValue, $subjectId, $grade)
    {
        $schoolId = session()->get('user.userable.school_id');
        $schoolApi = new SchoolApi;
        $subject = $schoolApi->subjectDetail($schoolId, $subjectId);

        if (!isset($subject['data'])) {
            return redirect('teacher/' . $teacherType . '/' . $assessmentGroupValue)->with(
                ['message' => 'Data Tidak Ditemukan!'],
            );
        }

        $viewBlade = 'teacher.' . $teacherType . '.student_groups.index';

        return view($viewBlade)
            ->with('assessmentGroup', $this->assessmentGroups($assessmentGroupValue))
            ->with('subject', $subject['data'])
            ->with('assessmentGroupValue', $assessmentGroupValue)
            ->with(
                'assessmentGroupId',
                $this->assessmentGroups($assessmentGroupValue, 'value'),
            )
            ->with('subject', $subject['data'])
            ->with('type', $teacherType)
            ->with('subjectId', $subjectId)
            ->with('grade', $grade);
    }

    public function entryYear($grade)
    {
        $yearNow = Carbon::now()->year;

        $year = [
            '10' => $yearNow . '/' . ($yearNow + 1),
            '11' => ($yearNow - 1) . '/' . $yearNow,
            '12' => ($yearNow - 2) . '/' . ($yearNow - 1),
        ];

        return $year[$grade];
    }

    public function studentGroupData(Request $req)
    {
        $schoolId = session()->get('user.userable.school_id');
        $filter = [
            'page' => ($req->page ?? 1),
            'per_page' => 99,
            'filter[entry_year]' => $this->entryYear($req->grade),
        ];
        $BatchApi = new BatchApi;
        $batch = $BatchApi->index($schoolId, $filter);
        $StudentGroupApi = new StudentGroupApi;
        $StudentGroup = [];

        if ($batch['meta']['total'] === 0) {
            if (isset($req->htmlView)) {
                if ($req->htmlView === 'accordion') {
                    $view = [
                        'data' => $StudentGroup,
                        'html' => '<h2 class="text-center">Tidak Ada Data</h2>',
                    ];
                }
            } else {
                $view = $this->studentGroupHtml($StudentGroup, $req->all());
            }

            return response()->json($view);
        }

        foreach ($batch['data'] as $v) {
            $StudentGroupData = $StudentGroupApi->index($schoolId, $v['id'], $filter);
            if (!isset($StudentGroupData['data'])) {
                continue;
            }

            $StudentGroup = array_merge($StudentGroup, $StudentGroupData['data']);
        }

        if (isset($req->htmlView)) {
            if ($req->htmlView === 'accordion') {
                $view = [
                    'data' => $StudentGroup,
                    'html' => $this->studentGroupAccordionHtml($StudentGroup),
                ];
            }
        } else {
            $view = $this->studentGroupHtml($StudentGroup, $req->all());
        }

        return response()->json($view);
    }

    public function studentGroupHtml($data, $req)
    {
        $list = $data;
        $count = count($list);

        $view = '<div class="list-group" data-url="#" id="StudentGroupData">';
        if ($count > 0) {
            foreach ($list as $v) {
                $view .= '<div class="list-group-item">';
                $view .= '<a href="/teacher/' . $req['type'] . '/'
                    . $req['assessmentGroupValue'] . '/subject/' . $req['subjectId'] .
                    '/' . $req['grade'] . '/student-groups/' . $v['id'] . '" class="col-10">';
                $view .= '<i class="kejar-rombel"></i>';
                $view .= '<span>' . $v['name'] . '</span>';
                $view .= '</a>';
                $view .= '</div>';
            }
        } else {
            $view .= '<h5 class="text-center">Tidak ada data</h5>';
        }

        $view .= '</div>';

        return $view;
    }

    public function studentGroupDetail($teacherType, $assessmentGroupId, $subjectId, $grade, $student_group_id)
    {
        $schoolId = session()->get('user.userable.school_id');
        $schoolApi = new SchoolApi;
        $subject = $schoolApi->subjectDetail($schoolId, $subjectId);
        $StudentGroupApi = new StudentGroupApi;
        $StudentGroupDetail =
            $StudentGroupApi->detailWithoutBatch($student_group_id);

        if (!isset($subject['data']) && !isset($StudentGroupDetail['data'])) {
            return redirect('teacher/' . $teacherType . '/' . $assessmentGroupId)->with(
                ['message' => 'Data Tidak Ditemukan!'],
            );
        }

        $reportType = '';
        $token = '';
        if ($teacherType === 'supervisor') {
            $assessmentApi = new AssessmentApi;
            $filterMA = [
                'filter[grade]' => $grade,
                'filter[assessment_group_id]' => $assessmentGroupId,
                'filter[subject_id]' => $subjectId,
                'per_page' => 1,
            ];
            $getAssessment = $assessmentApi->index($filterMA);
            $reportType = $getAssessment['data'][0]['type'] ?? '';
            $token = $getAssessment['data'][0]['pdf_password'] ?? '';
        }

        return view('teacher.' . $teacherType . '.report.index')
            ->with('assessmentGroup', $this->assessmentGroups($assessmentGroupId))
            ->with(
                'assessmentGroupId',
                $this->assessmentGroups($assessmentGroupId, 'value'),
            )
            ->with('subject', $subject['data'])
            ->with('StudentGroupDetail', $StudentGroupDetail['data'])
            ->with('assessmentGroupValue', $assessmentGroupId)
            ->with('school_id', $schoolId)
            ->with('subjectId', $subjectId)
            ->with('type', $teacherType)
            ->with('reportType', $reportType)
            ->with('id', $student_group_id)
            ->with('token', $token)
            ->with('grade', $grade);
    }

    public function getStudentByStudentGroup(Request $req)
    {
        $UserApi = new UserApi;
        $filter = [
            'per_page' => 99,
            'filter[student_group_id]' => $req->student_group_id,
            'page' => ($req->page ?? 1),
        ];
        $students = $UserApi->students($filter);
        $html = '<tr><td class="text-center" colspan="6">Tidak ada data</td></tr>';

        if ($students['status'] === 200 && $students['data']) {
            $html = '';
            foreach ($students['data'] as $key => $v) {
                $html .= '<tr>';
                $html .= '<td class="text-center">';
                $html .= $key + 1;
                $html .= '</td>';
                $html .= '<td id="student-data-' . $v['id'] . '">';
                $html .= $v['name'];
                $html .= '</td>';
                $html .= '<td id="student-data-loading-' . $v['id'] . '"
                                    colspan="' . ($req->colspan ?? 1) . '">
                                <div class="spinner-border mr-1" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div> Loading</td>';
                $html .= '</tr>';
            }
        }

        $data = [
            'status' => $students['status'],
            'data' => $students['data'],
            'html' => $html,
        ];

        return response()->json($data);
    }

    public function getStudentByStudentGroupSchedules(Request $req)
    {
        $UserApi = new UserApi;
        $filter = [
            'per_page' => 99,
            'filter[student_group_id]' => $req->student_group_id,
            'page' => ($req->page ?? 1),
        ];
        $students = $UserApi->students($filter);
        $html = '<tr><td class="text-center" colspan="6">Tidak ada data</td></tr>';

        if ($students['status'] === 200 && $students['data']) {
            $schoolId = session()->get('user.userable.school_id');
            $ScheduleApi = new ScheduleApi;

            $ScheduleFilter = [
                'per_page' => 99,
                'filter[assessment_group_id]' => $req->assessment_group_id,
                'filter[student_group_id]' => ($req->student_group_id ?? ''),
                'filter[subject_id]' => ($req->subject_id ?? ''),
                'page' => ($req->page ?? 1),
            ];

            $scheduleStudents = $ScheduleApi->index($schoolId, $ScheduleFilter);

            $studentIdScheduleCreated = [];
            $getSchedule = [];
            if ($scheduleStudents['meta']['total'] > 0) {
                foreach ($scheduleStudents['data'] as $key => $v) {
                    $studentIdScheduleCreated[] = $v['student_id'];
                    $getSchedule[$v['student_id']] = $v;
                }
            }

            if ($studentIdScheduleCreated) {
                $html = '';
            }

            $dataStudent = [];
            foreach ($students['data'] as $key => $v) {
                $student = $v;
                $dataStudent[$key] = $student;

                $name = $student['name'];
                $nis = $student['nis'];

                if (!in_array($v['id'], $studentIdScheduleCreated)) {
                    // Siswa tidak ada jadwal
                    $html .= '<tr>';
                        $html .= '<td class="text-center">'. ($key+1) .'</td>';
                        $html .= '<td>'. $name .'</td>';
                        $html .= '<td colspan="' . ($req->colspan ?? 1) . '"><span style="cursor:pointer"
                        onclick="noScheduleModal('. ("'".$name."'") .')">Belum ditugaskan</span></td>';
                    $html .= '</tr>';

                    continue;
                }

                // Siswa Ada jadwal

                $schedule = $getSchedule[$v['id']];
                $id = $schedule['id'];

                $dataStudent[$key]['schedule'] = $schedule;

                $html .= '<tr>';
                    $html .= '<td class="text-center">'. ($key+1) .'</td>';
                    $html .= '<td>'. $name .'</td>';
                    $presenceText = ($schedule['presence'] ? 'Hadir' : 'Tandai');
                    $presenceVal = ($schedule['presence'] ? 0 : 1);

                    $taskStatus = $schedule['status_task'];
                    $presenceParams = "'" . $schedule['id'] . "'," . $presenceVal;

                if (!$presenceVal) {
                    $presenceParams .= ",1,'" . $name . "'";
                } else {
                    $presenceParams .= ",0,'" . $name . "'";
                }

                    $presence = '<span class="btn btn-link p-0 '.
                    ($presenceText === 'Hadir' ? 'text-dark' : '') .' btn-lg
                    text-decoration-none" onclick="changePresence(' . $presenceParams . ')">'
                    . $presenceText . '</span>';
                    $teacherNote = ($schedule['teacher_note'] ?? '');
                    $studentNote = ($schedule['student_note'] === '' &&
                                    $studentNote === '-' ? '' : $schedule['student_note']);

                if (isset($req->reportType) && $req->reportType === 'ASSESSMENT') {
                    $html .= '<td>' . ($schedule['token'] ?? '-') . '</td>';
                }

                    $html .= '<td id="presenceBtn-' . $schedule['id'] . '">' . $presence . '</td>';
                if ($taskStatus === 'Done') {
                    $html .= '<td>Selesai</td>';

                    $html .= '<td><span ';
                    if (!$studentNote) {
                        $html .=' class="text-grey"';
                    }

                    $html .= ' >'.($studentNote ?: 'Tidak ada') . '</span></td>';
                } elseif ($taskStatus === 'Ongoing') {
                    $html .= '<td colspan="2">Sedang mengerjakan</td>';
                } elseif ($taskStatus === 'Undone') {
                    $html .= '<td colspan="2">Belum mengerjakan</td>';
                } else {
                    $html .= '<td colspan="2">Status tidak diketahui ('. $taskStatus .')</td>';
                }

                    // Note

                    $note = "'" . $id . "','" .
                        $studentNote . "','" .
                        $teacherNote . "','" .
                        $nis . "','" .
                        $name . "'";

                    $html .= '<td>';

                        $html .= '<div id="note-data-' . $id . '">';
                            $html .= '<span style="cursor: pointer;"';
                if (!$teacherNote) {
                    $html .=' class="text-grey"';
                }

                            $html .= 'onclick="changeNote(' . $note . ')">';
                            $html .= $this->noteData($teacherNote);
                            $html .= '</span;>';
                        $html .= '</div>';

                    $html .= '</td>';
                $html .= '</td>';
            }
        }

        $data = [
            'status' => $students['status'],
            'data' => $dataStudent,
            'html' => $html,
        ];

        return response()->json($data);
    }

    public function setTypeAssessment($teacherType, $assessmentGroupId, $subjectId, $grade, $assessType)
    {
        session()->put('assessmentType', $assessType);

        return redirect('teacher/'.$teacherType.'/'.
        $assessmentGroupId.'/subject/'.$subjectId.'/'.$grade.'/assessment');
    }

    public function assessment($teacherType, $assessmentGroupId, $subjectId, $grade, Request $request)
    {
        $schoolId = session()->get('user.userable.school_id');
        $year = '';

        if ($grade === '10' || $grade === '7') {
            $year = Carbon::now()->year . '/' . Carbon::now()->add(1, 'year')->year;
        }

        if ($grade === '11' || $grade === '8') {
            $year = Carbon::now()->sub(1, 'year')->year . '/' . Carbon::now()->year;
        }

        if ($grade === '12' || $grade === '9') {
            $year = Carbon::now()->sub(1, 'year')->year . '/' . Carbon::now()->sub(2, 'year')->year;
        }

        $batchApi = new BatchApi;

        $batchFilter = [
            'filter[entry_year]' => $year,
        ];

        $batchResponse = $batchApi->index($schoolId, $batchFilter);

        $batchResult = $batchResponse['data'] ?? [];

        $studentGroupApi = new StudentGroupApi;
        $studentGroup = [];
        foreach ($batchResult as $data) {
            $classResponse = $studentGroupApi->index($schoolId, $data['id']);
            $studentGroup = array_merge($studentGroup, $classResponse['data'] ?? []);
        }

        $assessmentGroup = $this->assessmentGroups($assessmentGroupId);

        $schoolApi = new SchoolApi;

        $subjectDetail = $schoolApi->subjectDetail($schoolId, $subjectId);

        $assessmentApi = new AssessmentApi;
        $filterMA = [
            'filter[grade]' => $grade,
            'filter[assessment_group_id]' => $assessmentGroupId,
            'filter[subject_id]' => $subjectId,
        ];
        $assessments = $assessmentApi->index($filterMA);
        $dataAssessment = ($assessments['data'] ?? []);

        $dualData = false;
        foreach ($dataAssessment as $item) {
            if ($item['type'] !== $dataAssessment[0]['type']) {
                $dualData = true;
            }
        }

        $viewType = '';
        $dataForAssessment = [];
        $viewType = session()->get('assessmentType') !== null && $dualData === true ? strtoupper(
            session()->get('assessmentType'),
        ) : ($dataAssessment[0]['type'] ?? '');

        if ($dualData === true) {
            foreach ($dataAssessment as $item) {
                if ($item['type'] === $viewType) {
                    array_push($dataForAssessment, $item);
                }
            }
        } else {
            $dataForAssessment = $dataAssessment;
        }

        $questions = [];
        $questionMeta = null;
        $newestPackStatus = '';
        $filter = 0;
        if (count($dataAssessment) > 0) {
            $getQuestions = $assessmentApi->questions($dataAssessment[0]['id'], $request->page ?? 1);
            if (count($dataAssessment) === 1) {
                foreach ($getQuestions['data'] as $value) {
                    if ($value['answer'] !== '') {
                        $filter += 1;
                    }
                }

                $newestPackStatus = ($filter !== count($getQuestions['data']) ? $dataAssessment[0]['id'] : '');
            } else {
                $getQuestsMore = $assessmentApi->questions(
                    $dataAssessment[count($dataAssessment) - 1]['id'],
                    $request->page ?? 1,
                );
                foreach ($getQuestsMore['data'] as $value) {
                    if ($value['answer'] !== '') {
                        $filter += 1;
                    }
                }

                $newestPackStatus = ($filter !== count($getQuestsMore['data']) ? $dataAssessment[count(
                    $dataAssessment,
                ) - 1]['id'] : '');
            }

            $questionMeta = $getQuestions['meta'] ?? null;
            $questions = $getQuestions['data'] ?? [];
        }

        return view('teacher.subject_teacher.assessment.index')
            ->with('assessmentGroupId', $assessmentGroupId)
            ->with('assessmentGroup', $assessmentGroup)
            ->with('assessments', $dataForAssessment)
            ->with('assessmentsMeta', $assessments['meta'])
            ->with('subject', $subjectDetail['data'])
            ->with('questions', $questions)
            ->with('questionMeta', $questionMeta)
            ->with('grade', $grade)
            ->with('dualType', $dualData)
            ->with('teacherType', $teacherType)
            ->with('type', $viewType)
            ->with('studentGroup', $studentGroup)
            ->with('newestPackStatus', $newestPackStatus);
    }

    // Editted
    public function createMiniAssessment(Request $request, $teacherType, $assessmentGroupId, $subjectId, $grade)
    {
        $teacherType;
        $assessmentApi = new AssessmentApi;
        if ($request['type'] === 'MINI_ASSESSMENT') {
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
            if (!$create['error']) {
                return redirect()->back()->with(['type' => 'success', 'message' => 'Data berhasil tersimpan!']);
            }

            return redirect()->back()->with(['type' => 'danger', 'message' => 'Data gagal tersimpan!']);
        }

        $reqFile = [];
        $assessPayload = [
            'duration' => 0,
            'subject_id' => $subjectId,
            'grade' => $grade,
            'assessment_group_id' => $assessmentGroupId,
            'type' => 'ASSESSMENT',
            'pdf_password' => '',
            'total_question' => 0,
            'total_choices' => 0,
        ];

        return $assessmentApi->create($reqFile, $assessPayload);
    }

    public function createAssessQuestion($type, $assessmentId, $subjectId, Request $request)
    {
        try {
            $type;
            $questionApi = new QuestionApi;
            $assessmentApi = new AssessmentApi;

            $choices = [];
            $alphabet = 'A';
            foreach ($request['choices'] as $key => $choice) {
                if (!is_null($choice)) {
                    $choices[$alphabet] = $choice;
                    if ($key === intval($request['answer'])) {
                        $answer = $alphabet;
                    }

                    $alphabet++;
                }
            }

            if (count($choices) <= 0 || is_null($request['question']) || is_null($request['answer'])) {
                return redirect()->back()->with('message', 'Maaf terjadi kesalahan, silahkan ulangi kembali!');
            }

            $collection = [
                'subject_id' => $subjectId,
                'topic_id' => null,
                'bank' => null,
                'question' => $request['question'],
                'level' => 'LEVEL_1',
                'created_by' => session()->get('user.id'),
                'type' => 'MCQSA',
                'status' => '1',
                'choices' => $choices,
                'answer' => $answer,
            ];

            $question = $questionApi->store($collection);

            $updateData = [
                'explanation' => (string)$request['explanation'],
                'explained_by' => session()->get('user.id'),
                'tags' => ['explanation'],
                'note' => 'explanation',
            ];

            $questionApi->update($question['data']['id'], ['status' => '2']);
            $questionApi->update($question['data']['id'], $updateData);

            $qaPayload = [
                'ids' => [$question['data']['id']],
            ];

            $assessmentApi->createQuestion($assessmentId, $qaPayload);
        } catch (Throwable $th) {
            return $th;
        }

        return redirect()->back()->with('message', 'Berhasil menambahkan data!');
    }

    public function editQuestion($type, $questionId)
    {
        $type;
        $questionApi = new QuestionApi;
        session()->put('questionId', $questionId);

        $questionDetail = $questionApi->getDetail($questionId)['data'];

        return response()->json($questionDetail);
    }

    public function updateAssessQuestion($type, $questionId, Request $request)
    {
        try {
            $type;
            $questionApi = new QuestionApi;
            $questionDetail = $questionApi->getDetail($questionId);

            $choices = [];
            $alphabet = 'A';
            foreach ($request['choices'] as $key => $choice) {
                if (!is_null($choice)) {
                    $choices[$alphabet] = $choice;
                    if ($key === intval($request['answer'])) {
                        $answer = $alphabet;
                    }

                    $alphabet++;
                }
            }

            if (count($choices) <= 0 || is_null($request['question']) || is_null($request['answer'])) {
                return redirect()->back();
            }

            $collection = [
                'question' => $request['question'],
                'choices' => $choices,
                'answer' => $answer,
                'type' => $questionDetail['data']['type'],
                'tags' => ['answer', 'question'],
                'created_by' => $questionDetail['data']['created_by'],
            ];

            $questionApi->update($questionId, $collection);

            $updateData = [
                'explanation' => (string)$request['explanation'],
                'explained_by' => session('user.id'),
                'tags' => ['explanation'],
                'note' => 'explanation',
            ];

            $questionApi->update($questionId, $updateData);

            return redirect()->back()->with('message', 'Berhasil mengubah soal!');
        } catch (Throwable $th) {
            return redirect()->back()->with('message', 'Maaf terjadi kesalahan, silahkan ulangi kembali!');
        }
    }
    // Editted

    public function settingMiniAssessment(
        Request $request,
        $teacherType,
        $assessmentGroupId,
        $subjectId,
        $grade,
        $assessmentId
    ) {
        $teacherType;
        $assessmentApi = new AssessmentApi;
        $assessmentDetail = $assessmentApi->detail($assessmentId);
        $payload = [
            'duration' => $request['duration'],
            'subject_id' => $subjectId,
            'grade' => $grade,
            'assessment_group_id' => $assessmentGroupId,
            'type' => $assessmentDetail['data']['type'],
            'pdf_password' => $request['pdf_password'],
        ];
        $update = $assessmentApi->update($assessmentId, $payload);
        if ($update) {
            return redirect()->back()->with(['type' => 'success', 'message' => 'Data berhasil diperbaharui!']);
        }

        return redirect()->back()->with(['type' => 'danger', 'message' => 'Data gagal diperbaharui!']);
    }

    public function durationAssessment()
    {
        $assessmentApi = new AssessmentApi;
        $assessmentId = $this->request->input('assessmentId');
        $payload = [
            'duration' => $this->request->input('duration'),
            'subject_id' => $this->request->input('subjectId'),
            'grade' => $this->request->input('grade'),
            'assessment_group_id' => $this->request->input('assessmentGroupId'),
        ];

        return $assessmentApi->update($assessmentId, $payload);
    }

    public function viewQuestion($teacherType, $id)
    {
        $teacherType;
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

    public function deleteQuestion()
    {
        $assessmentApi = new AssessmentApi;
        $questionApi = new QuestionApi;

        $assessmentId = $this->request->input('assessmentId');
        $ids = ($this->request->input('newList') ?? []);

        $questionApi->update($ids['0'], ['status' => '3']);

        $qaPayload = [
            'ids' => $ids,
            'action' => 'delete',
        ];

        return $assessmentApi->editQuestion($assessmentId, $qaPayload);
    }

    public function checkQuestion($teacherType, $id)
    {
        $teacherType;
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

    public function updateQuestion($teacherType)
    {
        $teacherType;
        $questionService = new QuestionApi;

        $answer = $this->request->input('answer');
        $questionId = $this->request->input('questionId');

        $questionDetail = $questionService->getDetail($questionId);

        // $payload = [];
        // if ($questionDetail['data']['type'] === 'MCQSA') {
        //     $choices = [];
        //     foreach ($this->request->input('choices') as $key => $v) {
        //         $choices[$key] = $v;
        //     }

        //     $payload = [
        //         'explanation' => $this->request->input('explanation'),
        //         'explained_by' => session()->get('user.id'),
        //     ];
        //     $questionService->update($questionId, $payload);
        //     $payload = [
        //         'type' => $questionDetail['data']['type'],
        //         'question' => $this->request->input('question'),
        //         'choices' => $choices,
        //         'answer' => $this->request->input('trueAnswer'),
        //         'created_by' => $questionDetail['data']['created_by'],
        //     ];
        // } else {
        $payload = [
            'answer' => $answer,
            'created_by' => $questionDetail['data']['created_by'],
            'question' => $questionDetail['data']['question'],
            'type' => $questionDetail['data']['type'],
        ];
        // }

        return $questionService->update($questionId, $payload);
    }

    public function validationQuestion($teacherType)
    {
        $teacherType;
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

    private function noteData($val)
    {
        if ($val === '-' || !$val) {
            $val = 'Belum ada catatan';
        }

        return $val;
    }

    public function studentAttendance(Request $req)
    {

        $ScheduleApi = new ScheduleApi;
        $filter = [
            'filter[student_id]' => $req->student_id,
            'filter[assessment_group_id]' => $req->assessment_group_id,
            'filter[subject_id]' => $req->subject_id,
            'per_page' => 1,
        ];
        $getSchedule = $ScheduleApi->index($req->school_id, $filter);

        $schedule = ($getSchedule['data'][0] ?? []);

        if (!$schedule) {
            $data = [
                'status' => 404,
            ];

            return response()->json($data);
        }

        $userApi = new UserApi;
        $student = $userApi->detailStudent($req->student_id);

        $id = $schedule['id'];
        $name = $student['data']['name'];
        $nis = $student['data']['nis'];

        $status = $getSchedule['status'];
        $html = '';
        $presenceText = ($schedule['presence'] ? 'Hadir' : 'Tandai');
        $presenceVal = ($schedule['presence'] ? 0 : 1);

        $taskStatus = $schedule['status_task'];
        $presenceParams = "'" . $schedule['id'] . "'," . $presenceVal;

        if (!$presenceVal) {
            $presenceParams .= ",1,'" . $name . "'";
        } else {
            $presenceParams .= ",0,'" . $name . "'";
        }

        $presence = '<span class="btn btn-link p-0 '. ($presenceText === 'Hadir' ? 'text-dark' : '') .' btn-lg
        text-decoration-none" onclick="changePresence(' . $presenceParams . ')">' . $presenceText . '</span>';

        $teacherNote = ($schedule['teacher_note'] ?? '');
        $studentNote = ($schedule['student_note'] ?? '');

        $studentNote = $schedule['student_note'] === '-' || $schedule['student_note'] ?: '';

        if (isset($req->reportType) && $req->reportType === 'ASSESSMENT') {
            $html .= '<td>' . ($schedule['token'] ?? '-') . '</td>';
        }

        $html .= '<td id="presenceBtn-' . $schedule['id'] . '">' . $presence . '</td>';
        if ($taskStatus === 'Done') {
            $html .= '<td>Selesai</td>';
            $html .= '<td><span class="text-grey">' . ($studentNote ?: 'Tidak ada') . '</span></td>';
        } elseif ($taskStatus === 'Ongoing') {
            $html .= '<td colspan="2">Sedang mengerjakan</td>';
        } elseif ($taskStatus === 'Undone') {
            $html .= '<td colspan="2">Belum mengerjakan</td>';
        } else {
            $html .= '<td colspan="2">Status tidak diketahui ('. $taskStatus .')</td>';
        }

        // Note

        $note = "'" . $id . "','" .
            $studentNote . "','" .
            $teacherNote . "','" .
            $nis . "','" .
            $name . "'";

        $html .= '<td>';

        $html .= '<div id="note-data-' . $id . '">';
        $html .= '<span style="cursor: pointer;" class="text-grey"
                    onclick="changeNote(' . $note . ')">';
        $html .= $this->noteData($teacherNote);
        $html .= '</span>';
        $html .= '</div>';

        $html .= '</td>';

        $data = [
            'status' => $status,
            'html' => $html,
        ];

        return response()->json($data);
    }

    public function studentAttendanceUpdate(Request $req)
    {
        $schoolId = session()->get('user.userable.school_id');
        $ScheduleApi = new ScheduleApi;
        $payload = [
            'schedule_ids' => [$req->schedule_id],
        ];

        if (isset($req->presence)) {
            $payload['presence'] = (int)$req->presence;
        }

        if (isset($req->teacher_note) || isset($req->student_note)) {
            $payload['notes']['teacher'] = $req->teacher_note;
            $payload['notes']['student'] = $req->student_note;
        }

        $update = $ScheduleApi->update($schoolId, $payload);

        return response()->json($update);
    }

    public function schoolGroupData(Request $req)
    {
        $schoolId = session()->get('user.userable.school_id');
        $filter = [
            'page' => ($req->page ?? 1),
            'per_page' => 99,
            'filter[entry_year]' => $this->entryYear($req->grade),
        ];
        $BatchApi = new BatchApi;
        $batch = $BatchApi->index($schoolId, $filter);
        $StudentGroupApi = new StudentGroupApi;
        $StudentGroup = [];

        if ($batch['meta']['total'] === 0) {
            if (isset($req->htmlView)) {
                if ($req->htmlView === 'accordion') {
                    $view = [
                        'data' => $StudentGroup,
                        'html' => '<h2 class="text-center">Tidak Ada Data</h2>',
                    ];
                }
            } else {
                $view = $this->studentGroupHtml($StudentGroup, $req->all());
            }

            return response()->json($view);
        }

        foreach ($batch['data'] as $v) {
            $StudentGroupData = $StudentGroupApi->index($schoolId, $v['id'], $filter);
            if (!isset($StudentGroupData['data'])) {
                continue;
            }

            $StudentGroup = array_merge($StudentGroup, $StudentGroupData['data']);
        }

        if (isset($req->htmlView)) {
            if ($req->htmlView === 'accordion') {
                $view = [
                    'data' => $StudentGroup,
                    'html' => $this->studentGroupAccordionHtml($StudentGroup),
                ];
            }
        } else {
            $view = $this->studentGroupHtml($StudentGroup, $req->all());
        }

        return response()->json($view);
    }

    public function studentGroupAccordionHtml($data)
    {
        $html = '';
        foreach ($data as $v) {
            $html .= '<div class="accordion mt-3" id="accordion-' . $v['id'] . '">';
            $html .= '<div class="card">';
            $html .= '<div class="card-header">';
            $idVal = "'" . $v['id'] . "'";
            $html .= '<h5 class="mb-0"
                        onclick="getStudents(' . $idVal . ')">';
            $html .= '<div class="row">';
            $html .= '<div class="col-1 ml-1">';
            $html .= '<input type="checkbox" data-toggle="collapse"
                                    data-target="#collapseStudents-' . $v['id'] . '"
                                    aria-expanded="true" aria-controls="collapseStudents-' . $v['id'] . '"
                                    id="schedule-check-all-' . $v['id'] . '"
                                    onclick="selectAllStudents(' . $idVal . ')"
                                    class="unCheckedData"
                                    value="1">';
            $html .= '</div>';
            $html .= '<div class="col pl-0" data-toggle="collapse"
                                          data-target="#collapseStudents-' . $v['id'] . '" aria-expanded="true"
                                          aria-controls="collapseStudents-' . $v['id'] . '" style="cursor: pointer;">';
            $html .= '<span data-toggle="collapse"
                                            data-target="#collapseStudents-' . $v['id'] . '"
                                            aria-expanded="true" aria-controls="collapseStudents-' . $v['id'] . '">';
            $html .= $v['name'];
            $html .= '</span>';
            $html .= '<span class="float-right">';
            $html .= '<span class="count-students-group
                                        count-students-group-' . $v['id'] . '">';
            $html .= 0;
            $html .= '</span >';
            $html .= ' siswa';
            $html .= '</span>';
            $html .= '</div>';
            $html .= '<div class="col-1" data-toggle="collapse"
                                            data-target="#collapseStudents-' . $v['id'] . '"
                                            aria-expanded="true" aria-controls="collapseStudents-' . $v['id'] . '">';
            $html .= '<i class="kejar-dropdown"></i>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</h5>';
            $html .= '</div>';
            $html .= '<table id="collapseStudents-' . $v['id'] . '" class="table table-bordered
                    table-sm m-0 collapse" aria-labelledby="headingOne" data-parent="#accordion-' . $v['id'] . '">';
            $html .= '<tr id="students-loading-' . $v['id'] . '">';
            $html .= '<td class="text-center">
                                        <div class="spinner-border mr-1" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div> Loading</td>';
            $html .= '</tr>';
            $html .= '</table>';
            $html .= '</div>';
            $html .= '</div>';
        }

        return $html;
    }

    public function getStudents(Request $req)
    {
        $UserApi = new UserApi;
        $filter = [
            'per_page' => 99,
            'filter[student_group_id]' => ($req->student_group_id ?? ''),
            'page' => ($req->page ?? 1),
        ];

        $data = $UserApi->students($filter);

        if (isset($req->check)) {
            if ($req->check === 'schedule' && $data['data']) {
                $schoolId = session()->get('user.userable.school_id');
                $ScheduleApi = new ScheduleApi;

                $ScheduleFilter = [
                    'per_page' => 99,
                    'filter[assessment_group_id]' => $req->assessment_group_id,
                    'filter[student_group_id]' => ($req->student_group_id ?? ''),
                    'filter[subject_id]' => ($req->subject_id ?? ''),
                    'page' => ($req->page ?? 1),
                ];

                $scheduleStudents = $ScheduleApi->index($schoolId, $ScheduleFilter);
                $studentIdScheduleCreated = [];
                if ($scheduleStudents['meta']['total'] > 0) {
                    foreach ($scheduleStudents['data'] as $key => $v) {
                        $studentIdScheduleCreated[] = $v['student_id'];
                    }
                }

                $dataStudent = [];
                foreach ($data['data'] as $key => $v) {
                    $dataStudent[$key] = $v;
                    $dataStudent[$key]['already_scheduled'] = false;
                    if (!in_array($v['id'], $studentIdScheduleCreated)) {
                        continue;
                    }

                    $dataStudent[$key]['already_scheduled'] = true;
                }

                $data['data'] = $dataStudent;
            }
        }

        return $data;
    }

    public function schedulesCreate(Request $req)
    {
        $schoolId = session()->get('user.userable.school_id');
        $data = [
            'student_ids' => explode(',', $req->data),
            'schedulable_type' => $req->type,
            'start_time' => $req->start_date,
            'finish_time' => $req->expiry_date,
            'token' => $req->token ?? null,
        ];

        if (isset($req->byNis)) {
            $UserApi = new UserApi;
            $studentIds = [];
            foreach ($data['student_ids'] as $key => $v) {
                $student = $UserApi->students(['filter[school_id]' => $schoolId, 'filter[search]' => $v]);
                $studentIds[$key] = $student['data'] ? $student['data'][0]['id'] : 'not found';
            }

            $data['student_ids'] = $studentIds;
        }

        if ($req->type === 'ASSESSMENT') {
            if ($req->typeAssesment === 'MINI_ASSESSMENT') {
                $data['schedulable_ids'] = explode(',', $req->assesment);
            } else {
                $data['schedulable_id'] = $req->assesment;
            }
        }

        $ScheduleApi = new ScheduleApi;
        $create = $ScheduleApi->bulkCreate($schoolId, $data);
        if ($create['status'] === 200) {
            $create['count_save'] = count($data['student_ids']);

            return response()->json($create);
        }

        return response()->json($create);
    }

    public function studentGroups(Request $req, $assessmentGroupId)
    {
        $meApi = new MeApi;
        $assessmentGroup = $this->assessmentGroups($assessmentGroupId);
        $filter = [
            'page' => ($req->page ?? 1),
            'filter[name]' => ($req->name ?? ''),
            'per_page' => 20,
        ];

        $studentGroups = $meApi->studentGroups($filter);

        return view('teacher.counselor.student-groups.index')
            ->with('assessmentGroupId', $assessmentGroupId)
            ->with('assessmentGroup', $assessmentGroup)
            ->with('studentGroups', $studentGroups['data'])
            ->with('studentGroupMeta', $studentGroups['meta']);
    }

    public function studentGroupSubject(Request $req, $assessmentGroupId, $studentGroupId)
    {
        $schoolId = session()->get('user.userable.school_id');
        $schoolApi = new SchoolApi;
        $filter = [
            'page' => ($req->page ?? 1),
            'filter[name]' => ($req->name ?? ''),
            'per_page' => 20,
        ];
        $subjects = $schoolApi->subjectIndex($schoolId, $filter);
        $studentGroup = $schoolApi->studentGroupDetail($studentGroupId);
        $assessmentGroup = $this->assessmentGroups($assessmentGroupId);

        return view('teacher.counselor.student-groups.subject.index')
            ->with('assessmentGroupId', $assessmentGroupId)
            ->with('assessmentGroup', $assessmentGroup)
            ->with('subjects', $subjects['data'])
            ->with('subjectMeta', $subjects['meta'])
            ->with('studentGroup', $studentGroup['data']);
    }

    public function studentGroupScore(Request $req, $assessmentGroupId, $studentGroupId, $subjectId)
    {
        $schoolId = session()->get('user.userable.school_id');
        $schoolApi = new SchoolApi;
        $subject = $schoolApi->subjectDetail($schoolId, $subjectId);
        $studentGroup = $schoolApi->studentGroupDetail($studentGroupId);

        $assessmentGroup = $this->assessmentGroups($assessmentGroupId);

        $dataScore = [];
        $AssessmentApi = new AssessmentApi;
        $filter = [
            'per_page' => 50,
            'filter[assessment_group_id]' => $assessmentGroupId,
            'filter[student_group_id]' => $studentGroupId,
            'filter[subject_id]' => $subjectId,
            'page' => ($req->page ?? 1),

        ];
        $dataList = $AssessmentApi->report($filter);

        if ($dataList['data'] !== null) {
            foreach ($dataList['data'] as $key => $i) {
                $dataScore[$key]['id'] = $i['id'];
                $dataScore[$key]['nis'] = $i['nis'];
                $dataScore[$key]['name'] = $i['name'];
                $dataScore[$key]['recommendation_score'] = (!is_null(
                    $i['latest_task'],
                ) ? $i['latest_task']['score'] : null);
                $dataScore[$key]['final_score'] = (!is_null(
                    $i['latest_task'],
                ) ? $i['latest_task']['final_score'] : null);
                $duration = (!is_null($i['latest_task']) ? Carbon::parse(
                    $i['latest_task']['start_time'],
                )->diffInMinutes($i['latest_task']['finish_time']) : null);
                $dataScore[$key]['duration'] = $duration;
            }
        }

        return view('teacher.counselor.student-groups.score.index')
            ->with('assessmentGroupId', $assessmentGroupId)
            ->with('assessmentGroup', $assessmentGroup)
            ->with('subject', $subject['data'])
            ->with('subjectMeta', $subject['meta'])
            ->with('studentGroup', $studentGroup['data'])
            ->with('scoreMeta', $dataList['meta'])
            ->with('scores', $dataScore);
    }

    public function counselingGroups($teacherType, $assessmentGroupValue)
    {
        $schoolId = session()->get('user.userable.school_id');
        $assessmentGroup = $this->assessmentGroups($assessmentGroupValue);
        $teacherId = session()->get('user.userable.id');
        $studentCounselorApi = new StudentCounselorApi;

        $filter = [
            'page' => 1,
            'per_page' => 20,
            'filter[homeroom_teacher_id]' => $teacherId,
        ];

        $studentCounselors = $studentCounselorApi->index($schoolId, $filter);
        if (!isset($studentCounselors['data'])) {
            $studentCounselors['data'] = [];
        }

        return view('teacher.counselor.student_counselor.counseling_groups.index')
            ->with('assessmentGroupValue', $assessmentGroupValue)
            ->with('assessmentGroup', $assessmentGroup)
            ->with('studentCounselors', $studentCounselors['data'])
            ->with('type', $teacherType);
    }

    public function subjectForCounselingGroups(Request $req, $teacherType, $assessmentGroupId, $studentCounselorId)
    {
        $assessmentGroupApi = new AssessmentGroupApi;
        $schoolId = session()->get('user.userable.school_id');
        $assessmentGroup = $assessmentGroupApi->detail($assessmentGroupId);
        $studentCounselorApi = new StudentCounselorApi;
        $studentCounselor = $studentCounselorApi->detail($schoolId, $studentCounselorId);

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

        return view('teacher.counselor.student_counselor.subjects.index')
            ->with('assessmentGroupId', $assessmentGroupId)
            ->with('teacherType', $teacherType)
            ->with('assessmentGroup', $assessmentGroup['data']['title'])
            ->with('subjects', $subjects['data'])
            ->with('studentCounselor', $studentCounselor['data'])
            ->with('subjectMeta', $subjects['meta']);
    }

    public function counselingGroupsReport($teacherType, $assessmentGroupId, $studentCounselorId, $subjectId)
    {
        $assessmentGroupApi = new AssessmentGroupApi;
        $schoolId = session()->get('user.userable.school_id');
        $assessmentGroup = $assessmentGroupApi->detail($assessmentGroupId);
        $studentCounselorApi = new StudentCounselorApi;
        $studentCounselor = $studentCounselorApi->detail($schoolId, $studentCounselorId);
        $schoolApi = new SchoolApi;
        $subject = $schoolApi->subjectDetail($schoolId, $subjectId);

        return view('teacher.counselor.student_counselor.report.index')
            ->with('assessmentGroupId', $assessmentGroupId)
            ->with('teacherType', $teacherType)
            ->with('subject', $subject['data'])
            ->with('assessmentGroup', $assessmentGroup['data']['title'])
            ->with('studentCounselor', $studentCounselor['data']);
    }

    public function reportStudent(Request $req)
    {
        $AssessmentApi = new AssessmentApi;
        $filter = [
            'page' => ($req->page ?? 1),
            'filter[assessment_group_id]' => ($req->assessment_group_id ?? ''),
            'filter[subject_id]' => ($req->subject_id ?? ''),
            'filter[grade]' => ($req->grade ?? ''),
            'filter[student_counselor_id]' => ($req->student_counselor_id ?? ''),
            'per_page' => 40,
        ];
        $data = $AssessmentApi->report($filter, $req->all());
        $return = $this->reportStudentCounselorHtml($data, $req->all());

        return response()->json($return);
    }

    private function reportStudentCounselorHtml($data, $req)
    {
        $dataArray = $data['data'];
        $view = '';
        if ($dataArray) {
            foreach ($dataArray as $key => $v) {
                // view
                $view .= '<tr>';
                $view .= '<td class="text-center">' . ($key+1) . '</td>';
                $view .= '<td>' . $v['name'] . '</td>';
                $view .= '<td>' . $v['nis'] . '</td>';
                $view .= '<td id="score-' . $v['id'] . '">' . $v['student_group']['name'] . '</td>';
                if ($v['schedule']) {
                    if ($v['latest_task']) {
                        if ($v['latest_task']['finish_time']) {
                            $view .= '<td>'. ($v['latest_task']['score'] ?? '-') . '</td>';
                            $view .= '<td>'. ($v['latest_task']['final_score'] ?? '-') . '</td>';
                        } else {
                            $view .= '<td colspan="2"><span class="text-muted">Sedang dikerjakan.</span></td>';
                        }
                    } else {
                        $view .= '<td colspan="2"><span class="text-muted">Belum dikerjakan.</span></td>';
                    }
                } else {
                    $view .= '<td colspan="2"><span class="text-muted">Belum ditugaskan.</span></td>';
                }

                $view .= '</tr>';
            }
        }

        // Pagination
        $pgnt = '';
        $paginationFunction = $req['paginationFunction'];
        $page = (int)$req['page'];
        $meta = $data['meta'];

        if ($meta && $meta['total'] > 40) {
            $pgnt .= '<nav class="navigation mt-5">';
            $pgnt .= '<div>';
            $pgnt .= '<span class="pagination-detail">' . ($meta['to'] ?? 0)
                . ' dari ' . $meta['total'] . ' siswa</span>';
            $pgnt .= '</div>';
            $pgnt .= '<ul class="pagination">';
            $pgnt .= '<li class="page-item ' . ($page - 1 <= 0 ? 'disabled' : '') . '">';
            $pgnt .= '<a class="page-link" onclick="' .
                        $paginationFunction . '(' . $req['grade'] . ',' . ($page - 1) . ')"
                        href="javascript::void(0)" tabindex="-1">&lt;</a>';
            $pgnt .= '</li>';

            for ($i = 1; $i <= $meta['last_page']; $i++) {
                $pgnt .= '<li class="page-item ' . ($page === $i ? 'active disabled' : '') . '">';
                $pgnt .= '<a class="page-link" onclick="' .
                            $paginationFunction . '(' . $req['grade'] . ',' . $i . ')"
                            href="javascript::void(0)">' . $i . '</a>';
                $pgnt .= '</li>';
            }

            $pgnt .= '<li class="page-item ' . ($page + 1) . ' > ' . ($meta['last_page'] ? 'disabled' : '') . '">';
            $pgnt .= '<a class="page-link" onclick="' .
                        $paginationFunction . '(' . $req['grade'] . ',' . ($page + 1) . ')"
                        href="javascript::void(0)">&gt;</a>';
            $pgnt .= '</li>';
            $pgnt .= '</ul>';
            $pgnt .= '</nav>';
        }

        return [
            'data' => $dataArray,
            'html' => $view,
            'pgnt' => $pgnt,
        ];
    }

    public function score($teacherType, $assessmentGroupId, $subjectId, $grade, $studentGroupId)
    {
        $schoolId = session()->get('user.userable.school_id');
        $schoolApi = new SchoolApi;
        $subjectDetail = $schoolApi->subjectDetail($schoolId, $subjectId);

        $studentGroupDetail = $schoolApi->studentGroupDetail($studentGroupId);

        $assessmentGroup = $this->assessmentGroups($assessmentGroupId);

        $assessmentApi = new AssessmentApi;
        $filterMA = [
            'filter[grade]' => $grade,
            'filter[assessment_group_id]' => $assessmentGroupId,
            'filter[subject_id]' => $subjectId,
        ];
        $assessments = $assessmentApi->index($filterMA);
        $dataAssessment = ($assessments['data'] ?? []);

        $dualData = false;
        foreach ($dataAssessment as $item) {
            if ($item['type'] !== $dataAssessment[0]['type']) {
                $dualData = true;
            }
        }

        $viewType = '';
        $dataForAssessment = [];
        $viewType = session()->get('assessmentType') !== null && $dualData === true ? strtoupper(
            session()->get('assessmentType'),
        ) : ($dataAssessment[0]['type'] ?? '');

        if ($dualData === true) {
            foreach ($dataAssessment as $item) {
                if ($item['type'] === $viewType) {
                    array_push($dataForAssessment, $item);
                }
            }
        } else {
            $dataForAssessment = $dataAssessment;
        }

        return view('teacher.subject_teacher.assessment.score.index')
            ->with('teacherType', $teacherType)
            ->with('assessmentGroupId', $assessmentGroupId)
            ->with('assessmentGroup', $assessmentGroup)
            ->with('assessments', $dataForAssessment)
            ->with('subject', $subjectDetail['data'])
            ->with('grade', $grade)
            ->with('type', $viewType)
            ->with('studentGroup', $studentGroupDetail['data'] ?? [])
            ->with('message', 'Data success');
    }

    public function scoreBystudentGroup()
    {
        $assessmentGroupId = $this->request->input('assessmentGroupId');
        $subjectId = $this->request->input('subjectId');
        $studentGroupId = $this->request->input('studentGroupId');
        $type = $this->request->input('type');

        $reportApi = new ReportApi;
        $filter = [
            'filter[assessment_type]' => $type,
            'filter[assessment_group_id]' => $assessmentGroupId,
            'filter[student_group_id]' => $studentGroupId,
            'filter[subject_id]' => $subjectId,
        ];

        $reports = $reportApi->reportAssessment($filter);
        $dataReports = ($reports['data'] ?? []);

        $view = $this->scoreBystudentGroupHtmlNew($dataReports);

        return response()->json($view);
    }

    public function scoreBystudentGroupHtmlNew($data)
    {
        $list = $data;

        $view = '';

        if ($list === []) {
            $view .= '<tr class="tr-score-report">';
            $view .= '<td class="text-center" colspan="9">Data belum ada</td>';
            $view .= '</tr>';

            return $view;
        }

        foreach ($list as $key => $v) {
            $view .= '<tr class="tr-score-report">';
            $view .= '<td class="text-right">' . ($key + 1) . '</td>';
            $view .= '<td>' . $v['name'] . '</td>';
            $view .= '<td>' . $v['nis'] . '</td>';

            if ($v['schedule'] === null && $v['latest_task'] === null) {
                $view .= '<td colspan="6" class="text-grey-3">Belum ditugaskan.
                <a class="text-primary" style="cursor:pointer"\
                onclick="viewCreateSchedule(\'' . $v['id'] . '\',\'' . $v['name'] . '\')">Tugaskan Siswa</a></td>';
            }

            if ($v['schedule'] !== null && $v['latest_task'] === null) {
                $view .= '<td colspan="6" class="text-grey-3">Belum mengerjakan.
                <a class="text-primary" style="cursor:pointer"\
                onclick="viewUpdateSchedule(\'' . $v['id'] . '\',\'' .
                $v['name'] . '\',\'' . $v['schedule']['id'] . '\',\'' .
                $v['schedule']['start_time'] . '\',\'' . $v['schedule']['finish_time'] . '\',\'' .
                $v['schedule']['token'] . '\')"\
                >Edit Penugasan</a></td>';
            }

            if ($v['latest_task'] !== null) {
                $startTime = Carbon::parse($v['latest_task']['start_time']);
                $finishTime = Carbon::parse($v['latest_task']['finish_time']);
                $diff = $finishTime->diffInMinutes($startTime);
                $finalScore = $v['latest_task']['final_score'];
                $view .= '<td>' . $diff . '</td>';
                $view .= '<td>' . $v['latest_task']['answer_status']['correct'] . '</td>';
                $view .= '<td>' . $v['latest_task']['answer_status']['wrong'] . '</td>';
                $view .= '<td>' . $v['latest_task']['answer_status']['empty'] . '</td>';
                $view .= '<td class="text-right">' . $v['latest_task']['score'] . '</td>';
                $view .= '<td class="column-white" id="score-td-' . $v['latest_task']['id'] . '">';
                $view .= '<div class="row justify-content-end m-0 p-0" style="width:180px">';
                $view .= '<div style="width: 85%">';
                $view .= '<input type="number"
                                        onchange="handleChange(this);"
                                        onkeyup="handleChange(this);"
                                        id="score-input-' . $v['latest_task']['id'] . '"
                                        onblur="updateScore(\'' . $v['latest_task']['id'] . '\')"
                                        onfocus="modeEdit(\'' . $v['latest_task']['id'] . '\')"
                                        placeholder="Input Nilai" value="' . $finalScore . '"
                                        class="form-control text-right form-control-lg input-score-white" >';
                $view .= '</div>';
                $view .= '<div class="pt-1 pr-6" style="display:none; width: 10%"\
                id="score-alert-' . $v['latest_task']['id'] . '">';
                $view .= '</div>';
                $view .= '</div>';
                $view .= '</td>';
            }

            $view .= '</tr>';
        }

        return $view;
    }

    public function updateScore(Request $req)
    {
        $taskApi = new TaskApi;
        if (!$req->score) {
            return response()->json(false);
        }

        $update = $taskApi->updateFinalScore($req->id, ['final_score' => $req->score]);
        if ($update) {
            return response()->json(true);
        }

        return response()->json(false);
    }

    public function deleteSchedule($teacherType)
    {
        $teacherType;
        $scheduleApi = new ScheduleApi;

        $schoolId = session()->get('user.userable.school_id');

        $scheduleId = $this->request->input('scheduleId');

        return $scheduleApi->deleteSchedule($schoolId, $scheduleId);
    }

    public function updateSchedule($teacherType)
    {
        $teacherType;
        $schoolId = session()->get('user.userable.school_id');
        $ScheduleApi = new ScheduleApi;

        $scheduleId = $this->request->input('scheduleId');
        $startDate = $this->request->input('startDate');
        $expiryDate = $this->request->input('expiryDate');
        $token = $this->request->input('token');

        $payload = [
            'schedule_ids' => [$scheduleId],
            'start_time' => $startDate,
            'finish_time' => $expiryDate,
            'token' => $token ?? null,
        ];

        $update = $ScheduleApi->update($schoolId, $payload);

        return response()->json($update);
    }
}
