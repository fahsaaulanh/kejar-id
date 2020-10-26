<?php

namespace App\Http\Controllers\Teacher;

use App\Exports\MiniAssessment\ScoreBystudentGroupExport;
use App\Http\Controllers\Controller;
use App\Services\Batch as BatchApi;
use App\Services\MiniAssessment as miniAssessmentApi;
use App\Services\School as SchoolApi;
use App\Services\StudentGroup as StudentGroupApi;
use App\Services\User as UserApi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MiniAssessmentController extends Controller
{
    public function schoolId()
    {
        return session()->get('user.userable.school_id');
    }

    public function schoolIdForSubject()
    {
        $wikramaIdProdBogor = '3da67e44-ca12-4ae8-b784-f066ea605887';
        $wikramaIdProdGarut = '6286566b-a2ce-4649-9c0c-078c434215af';
        $wikramaIdStagingBogor = '73ceaf53-a9d8-4777-92fe-39cb55b6fe3b';
        $wikramaIdStagingGarut = '35fd6bcd-2df7-414d-b7e2-20b62490d561';

        $schoolId = session()->get('user.userable.school_id');

        if ((env('APP_ENV') === 'local' || env('APP_ENV') === 'staging') && $schoolId === $wikramaIdStagingGarut) {
            $schoolId = $wikramaIdStagingBogor;
        } elseif (env('APP_ENV') === 'production' && $schoolId === $wikramaIdProdGarut) {
            $schoolId = $wikramaIdProdBogor;
        }

        return $schoolId;
    }

    public function miniAssessmentGroups($val, $type = 'title')
    {
        $miniAssessmentGroup = $type === 'value' ? [
            'PTS-semester-ganjil-2020-2021' => 'pts ganjil 2020-2021',
            'PTS-susulan-semester-ganjil-2020-2021' => 'pts susulan ganjil 2020-2021',
        ] : [
            'PTS-semester-ganjil-2020-2021' => 'PTS Semester Ganjil 2020-2021',
            'PTS-susulan-semester-ganjil-2020-2021' => 'PTS Susulan Semester Ganjil 2020-2021',
        ];

        if ($type === 'header') {
            $miniAssessmentGroup = [
                'pts ganjil 2020-2021' => 'PTS Semester Ganjil 2020-2021',
                'pts susulan ganjil 2020-2021' => 'PTS Susulan Semester Ganjil 2020-2021',
            ];
        }

        return $miniAssessmentGroup[$val];
    }

    public function subjects(Request $req, $type, $miniAssessmentGroupValue)
    {
        $schoolIdForSubject = $this->schoolIdForSubject();
        $miniAssessmentGroup = $this->miniAssessmentGroups($miniAssessmentGroupValue);

        $schoolApi = new SchoolApi;
        $filter = [
            'page' => ($req->page ?? 1),
            'per_page' => 20,
        ];
        $subjects = $schoolApi->subjectIndex($schoolIdForSubject, $filter);
        if (!isset($subjects['data'])) {
            $subjects['data'] = [];
        }

        if (!isset($subjects['meta'])) {
            $subjects['meta'] = [];
        }

        return view('teacher.mini_assessments.subjects.index')
               ->with('miniAssessmentGroupValue', $miniAssessmentGroupValue)
               ->with('miniAssessmentGroup', $miniAssessmentGroup)
               ->with('subjects', $subjects['data'])
               ->with('type', $type)
               ->with('subjectMeta', $subjects['meta']);
    }

    public function package($type, $miniAssessmentGroupValue, $subjectId, $grade)
    {
        $schoolIdForSubject = $this->schoolIdForSubject();
        $schoolApi = new SchoolApi;
        $subject = $schoolApi->subjectDetail($schoolIdForSubject, $subjectId);


        if (!isset($subject['data'])) {
            return redirect('admin/mini-assessment/'.$miniAssessmentGroupValue)->with(
                ['message' => 'Data Tidak Ditemukan!'],
            );
        }

        return view('teacher.mini_assessments.subjects.subject_teachers.index')
               ->with('miniAssessmentGroup', $this->miniAssessmentGroups($miniAssessmentGroupValue))
               ->with('subject', $subject['data'])
               ->with('miniAssessmentGroupValue', $miniAssessmentGroupValue)
               ->with(
                   'miniAssessmentGroupId',
                   $this->miniAssessmentGroups($miniAssessmentGroupValue, 'value'),
               )
               ->with('subject', $subject['data'])
               ->with('type', $type)
               ->with('subjectId', $subjectId)
               ->with('grade', $grade)
               ->with('reportAccess', $this->reportAccess);
    }

    public function alphabet($val)
    {
        $array = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];

        return $array[$val];
    }

    public function dateFormat($val, $format = 'Y/m/d H:i:s')
    {
        $date=date_create($val);

        return date_format($date, $format);
    }

    public function view($id)
    {
        $miniAssessmentApi = new miniAssessmentApi;
        $detail= $miniAssessmentApi->detail($id);
        $data = [];
        $data['detail'] = $detail['data'];
        $data['detail']['created'] = '';
        if ($data['detail']['validated']) {
            $UserApi = new UserApi;
            $teacher = $UserApi->detailTeacher($data['detail']['validated_by']);
            $data['detail']['created'] = $teacher['data']['name'];
        }

        $data['time'] = $this->dateFormat($detail['data']['start_time'], 'd M Y').
                        ', '.$this->dateFormat($detail['data']['start_time'], 'H.i').
                        ' - '.$this->dateFormat($detail['data']['expiry_time'], 'H.i');

        $data['group'] = $this->miniAssessmentGroups($data['detail']['group'], 'header');
        $answersAPI = $miniAssessmentApi->answers($id);

        $no = 1;
        $choiceRow = 1;
        $choices = 'Tidak Ada Data';
        $multipleChoices = 'Tidak Ada Data';
        if ($answersAPI['data']) {
            $choices = '';
            $multipleChoices = '';
            foreach ($answersAPI['data'] as $v) {
                if (!is_array($v['answer'])) {
                    // choices
                    if ($choiceRow === 1) {
                        $choices .= '<div class="row mb-3">';
                    }

                        $choices .= '<div class="col">';
                            $choices .= '<div class="row">';
                                $choices .= '<div class="col-4 text-center mt-1">';
                                    $choices .= '<label>'.$no.'</label>';
                                $choices .= '</div>';
                                $choices .= '<div class="col-7">';
                                    $choices .= '<div class="form-group input-group-lg">';
                                        $choices .= '<input type="text" class="form-control" value="'
                                        .$v['answer'].'" readonly required="" autocomplete="off">';
                                    $choices .= '</div>';
                                $choices .= '</div>';
                            $choices .= '</div>';
                        $choices .= '</div>';

                    if ($choiceRow === 5) {
                        $choices .= '</div>';
                        $choiceRow = 0;
                    }

                    $choiceRow++;
                    $no++;
                } else {
                    // multiple choices
                    $multipleChoices .= '<div class="row mb-3">';
                        $multipleChoices .= '<div class="col-12">';
                            $multipleChoices .= '<div class="row">';
                                $multipleChoices .= '<div class="col-1">'.$no.'</div>';
                                $multipleChoices .= '<div class="col-8">';

                                $multipleChoices .= '<div class="row">';
                    for ($i=0; $i < $v['choices_number']; $i++) {
                        $multipleChoices .= '<div class="col-1 mr-4">';
                            $multipleChoices .= '<div class="form-check">';
                                $multipleChoices .=
                                '<input type="checkbox" class="form-check-input mt-2" id="exampleCheck'.$no.$i.'"';
                        if (in_array($this->alphabet($i), $v['answer'])) {
                                $multipleChoices .= 'checked';
                        }

                                $multipleChoices .= ' >';
                                $multipleChoices .= '<label class="form-check-label ml-2" for="exampleCheck'.$no.$i.'">'
                                .$this->alphabet($i).'</label>';
                            $multipleChoices .= '</div>';
                                        $multipleChoices .= '</div>';
                    }

                                $multipleChoices .= '</div>';

                                $multipleChoices .= '</div>';
                            $multipleChoices .= '</div>';
                        $multipleChoices .= '</div>';
                    $multipleChoices .= '</div>';
                    $no++;
                }
            }
        }

        $data['choices'] = $choices;
        $data['multipleChoices'] = $multipleChoices;

        return response()->json($data);
    }

    public function packageData(Request $req)
    {
        $miniAssessmentApi = new miniAssessmentApi;
        $group = $this->miniAssessmentGroups($req->miniAssessmentGroupValue, 'value');
        $filter = [
            'filter[subject_id]' => $req->subjectId,
            'filter[group]' => $group,
            'filter[grade]' => $req->grade,
            'page' => ($req->page ?? 1),
            'per_page' => 20,
        ];
        $miniAssessmentIndex = $miniAssessmentApi->index($filter);
        $view = $this->packageDataHtml($miniAssessmentIndex, $req->page, $req->paginationFunction);

        return response()->json($view);
    }

    public function packageDataHtml($data, $page, $paginationFunction)
    {
        $list = $data['data'];
        $meta = $data['meta'];
        $count = count($list);
        $view = '<div class="list-group" data-url="#" id="packageData">';
        if ($count > 0) {
            foreach ($list as $v) {
                $view .= '<div class="list-group-item" data-id="'.$v['id'].'">';
                    $view .= '<a href="javascript:void(0)" class="col-12">';
                        $view .= '<i class="kejar-penilaian" data-id="'.$v['id'].'"';
                        $view .= 'data-container="body" data-toggle="popover" data-placement="top"';
                        $view .= ' data-content="ID disalin!"></i> <span data-toggle="modal" data-target="#view-ma"';
                            $view .= ' onclick="viewMA(\''.$v['id'].'\')">'.$v['title'].'</span>';

                if ($v['validated'] === 1) {
                    $view .= '<i class="kejar-sudah-dikerjakan text-green-2 float-right" data-toggle="modal"';
                        $view .= ' onclick="viewMA(\''.$v['id'].'\')" data-target="#view-ma"></i>';
                }

                    $view .= '</a>';
                $view .= '</div>';
            }
        } else {
            $view .= '<h5 class="text-center">Tidak ada data</h5>';
        }

        $view .= '</div>';

        if ($meta && $meta['total'] > 20) {
            $view .= '<nav class="navigation mt-5">';
                $view .= '<div>';
                    $view .= '<span class="pagination-detail">'. ($meta['to'] ?? 0)
                            .' dari '. $meta['total'] .' paket</span>';
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

    public function entryYear($grade)
    {
        $yearNow = Carbon::now()->year;

        $year = [
            '10' => $yearNow.'/'.($yearNow+1),
            '11' => ($yearNow-1).'/'.$yearNow,
            '12' => ($yearNow-2).'/'.($yearNow-1),
        ];

        return $year[$grade];
    }

    public function schoolGroupData(Request $req)
    {
        $schoolId = $this->schoolId();
        $filter = [
            'page' => ($req->page ?? 1),
            'per_page' => 99,
            'filter[entry_year]' => $this->entryYear($req->grade),
        ];
        $BatchApi = new BatchApi;
        $batch = $BatchApi->index($schoolId, $filter);
        $StudentGroupApi = new StudentGroupApi;
        $StudentGroup = [];
        foreach ($batch['data'] as $v) {
            $StudentGroupData = $StudentGroupApi->index($schoolId, $v['id'], $filter);
            if (!isset($StudentGroupData['data'])) {
                continue;
            }

            $StudentGroup = array_merge($StudentGroup, $StudentGroupData['data']);
        }

        $view = $this->studentGroupHtml($StudentGroup, $req->all());

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
                    $view .= '<a href="/teacher/subject-teachers/mini-assessment/'
                                .$req['miniAssessmentGroupValue'].'/subject/'.$req['subjectId'].
                                '/'.$req['grade'].'/batch/'.$v['batch_id'].'/score/'.$v['id'].'" class="col-10">';
                        $view .= '<i class="kejar-rombel"></i>';
                        $view .= '<span>'.$v['name'].'</span>';
                    $view .= '</a>';
                    $param = "'".$req['miniAssessmentGroupValue']."',".
                             "'".$req['subjectId']."',".
                             "'".$req['grade']."',".
                             "'".$v['batch_id']."',".
                             "'".$v['id']."',".
                             "'".$v['name']."'";
                    $view .= '<span class="col row" style="cursor:pointer"
                    onclick="attendanceForm('.$param.')" >
                    <i class="kejar-edit float-right col-1">';
                    $view .= '</i><small class="col pl-2">Absensi</small></span>';
                $view .= '</div>';
            }
        } else {
            $view .= '<h5 class="text-center">Tidak ada data</h5>';
        }

        $view .= '</div>';

        return $view;
    }

    public function attendanceForm(Request $req, $id)
    {
        $UserApi = new UserApi;
        $filter = [
            'per_page' => 99,
            'filter[student_group_id]' => $id,
            'page' => ($req->page ?? 1),
        ];
        $students = $UserApi->students($filter);

        $data = [];

        if (!$students['data']) {
            $view = '<tr>
                        <td colspan="6" class="text-center">Tidak ada data</td>
                    </tr>';

            return response()->json($view);
        }

        $UserApi = new UserApi;
        foreach ($students['data'] as $key => $v) {
            $attendanceFilter = ['filter[group]' => 'pts ganjil 2020-2021'];
            $presence = $UserApi->attendanceIndex($v['id'], $attendanceFilter);
            $data[$key]['presence'] = 1;
            $data[$key]['value'] = 1;
            if (isset($presence['data'][0])) {
                $data[$key]['presence'] = "'".$presence['data'][0]['id']."'";
                $data[$key]['value'] = ($presence['data'][0]['status'] === 1 ? 0 : 1);
            }

            $data[$key]['id'] = $v['id'];
            $data[$key]['nis'] = $v['nis'];
            $data[$key]['name'] = $v['name'];
        }

        $payload = [
            'data' => $data,
            'meta' => $students['meta'],
        ];

        $view = $this->attendanceFormHtml($payload);

        return response()->json($view);
    }

    public function attendanceFormHtml($data)
    {

        $list = $data['data'];
        $view = '';
        foreach ($list as $key => $v) {
            $presenceParams = "'".$v['id']."',".$v['presence'].','.$v['value'];
            $presenceText = ($v['value'] === 1 ? 'Tandai' : 'Hadir');

            $presence = '<span class="btn btn-link btn-lg
            text-decoration-none" onclick="changePresence('.$presenceParams.')">'.$presenceText.'</span>';

            $view .= '<tr class="tr-score-report">';
                $view .= '<td class="text-center">'.($key+1).'</td>';
                $view .= '<td>'.$v['name'].'</td>';
                $view .= '<td>'.$v['nis'].'</td>';

                $view .= '<td><div id="presenceBtn-'. $v['id'] .'">'.$presence.'</div></td>';
            $view .= '</tr>';
        }

        return $view;
    }

    public function validation(Request $req)
    {
        $payload = [
            'validated'=>1,
            'validate_by'=> session()->get('user.id'),
        ];

        $miniAssessmentApi = new miniAssessmentApi;
        $miniAssessmentApi->updateValidation($req->id, $payload);

        return redirect()->back()->with(
            ['message' => 'Paket Berhasil Divalidasi!'],
        );
    }

    public function scoreBystudentGroup($type, $miniAssessmentGroupValue, $subjectId, $grade, $batchId, $studentGroupId)
    {
        if (!$this->reportAccess) {
            return redirect('teacher/games');
        }

        $schoolIdForSubject = $this->schoolIdForSubject();
        $schoolId = $this->schoolId();
        $schoolApi = new SchoolApi;
        $subject = $schoolApi->subjectDetail($schoolIdForSubject, $subjectId);
        $StudentGroupApi = new StudentGroupApi;
        $StudentGroupDetail = $StudentGroupApi->detail($schoolId, $batchId, $studentGroupId);

        if (!isset($subject['data']) && !isset($StudentGroupDetail['data'])) {
            return redirect('admin/mini-assessment/'.$miniAssessmentGroupValue)->with(
                ['message' => 'Data Tidak Ditemukan!'],
            );
        }

        return view('teacher.mini_assessments.subjects.subject_teachers.study_group_report.view')
                ->with('miniAssessmentGroup', $this->miniAssessmentGroups($miniAssessmentGroupValue))
                ->with(
                    'miniAssessmentGroupId',
                    $this->miniAssessmentGroups($miniAssessmentGroupValue, 'value'),
                )
                ->with('subject', $subject['data'])
                ->with('StudentGroupDetail', $StudentGroupDetail['data'])
                ->with('miniAssessmentGroupValue', $miniAssessmentGroupValue)
                ->with('subjectId', $subjectId)
                ->with('type', $type)
                ->with('batchId', $batchId)
                ->with('grade', $grade);
    }

    public function scoreBystudentGroupData(Request $req)
    {
        $UserApi = new UserApi;
        $filter = [
            'per_page' => 99,
            'filter[student_group_id]' => $req->student_group_id,
            'page' => ($req->page ?? 1),
        ];
        $students = $UserApi->students($filter);

        $data = [];
        $miniAssessmentApi = new miniAssessmentApi;

        if (!$students['data']) {
            $view = '<tr>
                        <td colspan="6" class="text-center">Tidak ada data</td>
                    </tr>';

            return response()->json($view);
        }

        $UserApi = new UserApi;
        foreach ($students['data'] as $key => $v) {
            $payload = [
                'filter[subject_id]' => $req->subjectId,
                'per_page' => 99,
                'finished' => 'true',
            ];
            $filterScore = [
                'filter[subject_id]' => $req->subjectId,
            ];
            $attendanceFilter = ['filter[group]' => 'pts ganjil 2020-2021'];
            $presence = $UserApi->attendanceIndex($v['id'], $attendanceFilter);
            $data[$key]['presence'] = 1;
            $data[$key]['value'] = 1;
            if (isset($presence['data'][0])) {
                $data[$key]['presence'] = "'".$presence['data'][0]['id']."'";
                $data[$key]['value'] = ($presence['data'][0]['status'] === 1 ? 0 : 1);
            }

            $score = $miniAssessmentApi->result($v['id'], $filterScore);
            $data[$key]['id'] = $v['id'];
            $data[$key]['nis'] = $v['nis'];
            $data[$key]['name'] = $v['name'];

            $data[$key]['score'] = [];
            $data[$key]['mini_assessment'] = [];
            $data[$key]['finished'] = false;

            if (!isset($score['data'])) {
                continue;
            }

            $lastData = count($score['data']);
            $lastData -=1;
            $detail= $miniAssessmentApi->detail($score['data'][$lastData]['mini_assessment_id']);
            $data[$key]['score'] = $score['data'][$lastData];
            $data[$key]['mini_assessment'] = $detail['data'];
            $data[$key]['finished'] = true;
        }

        // dd($data);
        $payload['data'] = $data;
        $payload['meta'] = $students['meta'];

        if (isset($req->forExport)) {
            return $payload;
        }

        $view = $this->scoreBystudentGroupHtml($payload);

        return response()->json($view);
    }

    private function noteData($val)
    {
        $val = $val ?: 'Belum ada catatan';

        return $val;
    }

    public function scoreBystudentGroupHtml($data)
    {
        $list = $data['data'];
        $view = '';
        foreach ($list as $key => $v) {
            $presenceParams = "'".$v['id']."',".$v['presence'].','.$v['value'];
            $presenceText = ($v['value'] === 1 ? 'Tandai' : 'Hadir');

            $presence = '<span class="btn btn-link btn-lg
            text-decoration-none" onclick="changePresence('.$presenceParams.')">'.$presenceText.'</span>';

            if ($v['finished']) {
                $diff = Carbon::parse($v['score']['start_time'])
                                ->diffInMinutes($v['score']['finish_time']);
                $view .= '<tr class="tr-score-report">';
                    $view .= '<td class="text-center">'.($key+1).'</td>';
                    $view .= '<td>'.$v['name'].'</td>';
                    $view .= '<td>'.$v['nis'].'</td>';

                    $view .= '<td><div id="presenceBtn-'. $v['id'] .'">'.$presence.'</div></td>';

                    $view .= '<td style="width:500px">';
                        // Note
                        $note = "'".$v['score']['id']."','".
                                $v['score']['student_note']."','".
                                $v['score']['teacher_note']."','".
                                $v['nis']."','".
                                $v['name']."'";
                        $view .= '<div id="note-data-'.$v['score']['id'].'">';
                            $view .= '<span style="cursor: pointer;" class="text-muted"
                                onclick="changeNote('.$note.')">';
                                $view .= $this->noteData($v['score']['teacher_note']);
                            $view .= '</span>';
                        $view .= '</div>';

                    $view .= '</td>';
                    $view .= '<td>'.$diff.'</td>';
                    $view .= '<td>'.$v['score']['score']['recommendation_score'].'</td>';
                    $view .= '<td class="column-white" id="score-td-'.$v['score']['id'].'">';
                        $view .= '<div class="row m-0 p-0" style="width:180px">';
                            $view .= '<div class="col">';
                                $view .= '<input type="number"
                                        onchange="handleChange(this);"
                                        onkeyup="handleChange(this);"
                                        id="score-input-'.$v['score']['id'].'"
                                        onblur="updateScore(\''.$v['score']['id'].'\')"
                                        onfocus="modeEdit(\''.$v['score']['id'].'\')"
                                        placeholder="Input Nilai" value="'.$v['score']['score']['final_score'].'"
                                        class="form-control form-control-lg input-score-white" >';
                            $view .= '</div>';
                            $view .= '<div class="col-1">';
                                $view .= '<div id="score-alert-'.$v['score']['id'].'">';
                                $view .= '</div>';
                            $view .= '</div>';
                        $view .= '</div>';
                    $view .= '</td>';
                $view .= '</tr>';
            } else {
                $view .= '<tr>';
                    $view .= '<td class="text-center">'.($key+1).'</td>';
                    $view .= '<td>'.$v['name'].'</td>';
                    $view .= '<td>'.$v['nis'].'</td>';
                    $view .= '<td><div id="presenceBtn-'. $v['id'] .'">'.$presence.'</div></td>';
                    $view .= '<td colspan="4">Belum mengerjakan</td>';
                $view .= '</tr>';
            }
        }

        return $view;
    }

    public function updatePresence(Request $req)
    {
        $UserApi = new UserApi;
        if ($req->presence !== 1) {
            // Update
            $payload = [
                'status' => $req->value,
            ];
            $UserApi->attendanceUpdate($req->id, $req->presence, $payload);
        } else {
            // Create
            $payload = [
                'subject_id' => $req->subject_id,
                'group' => $req->mini_assessment_group_id,
                'status' => 1,
            ];
            $create = $UserApi->attendanceCreate($req->id, $payload);
            $req['presence'] = $create['data']['id'];
        }

        $presenceParams = "'".$req['id']."','".$req['presence']."',".($req->value === '1' ? 0 : 1);
        $presenceText = ($req->value === '1' ? 'Hadir' : 'Tandai');
        $presence = '<span class="btn btn-link btn-lg text-decoration-none"
        onclick="changePresence('.$presenceParams.')">'.$presenceText.'</span>';

        return response()->json(['id' => $req->id, 'btn' => $presence, 'req' => $req->all()]);
    }

    public function updateScore(Request $req)
    {
        $miniAssessmentApi = new miniAssessmentApi;
        if (!$req->score) {
            $req->score = 0;
        }

        $update = $miniAssessmentApi->updateFinalScore($req->id, ['score' => $req->score]);
        if ($update) {
            return response()->json(true);
        }

        return response()->json(false);
    }

    public function scoreBystudentGroupExport(
        $type,
        $miniAssessmentGroupValue,
        $subjectId,
        $grade,
        $batchId,
        $studentGroupId
    ) {
        $payload =
                    [
                        'type' => $type,
                        'mini_assessment_group_id' => $miniAssessmentGroupValue,
                        'subjectId' => $subjectId,
                        'grade' => $grade,
                        'student_group_id' => $studentGroupId,
                        'forExport' => true,
                    ];
        $StudentGroupApi = new StudentGroupApi;

        $schoolId = $this->schoolId();
        $schoolIdForSubject = $this->schoolIdForSubject();

        $StudentGroupDetail = $StudentGroupApi->detail($schoolId, $batchId, $studentGroupId);
        $data = $this->scoreBystudentGroupData(new Request($payload));

        $schoolApi = new SchoolApi;
        $subject = $schoolApi->subjectDetail($schoolIdForSubject, $subjectId);
        $data['StudentGroupDetail'] = $StudentGroupDetail['data'];
        $fileName = 'Report '.$subject['data']['name'].' '.
        $data['StudentGroupDetail']['name'].' '.
        Carbon::now()->format('d-m-Y').'.xlsx';

        return Excel::download(new ScoreBystudentGroupExport($data), $fileName);

        // test view html export excel

        // return view('teacher.mini_assessments.subjects.subject_teachers.study_group_report._export')
        // ->with('data',$data);
    }

    public function updateNote(Request $req)
    {
        $miniAssessmentApi = new miniAssessmentApi;
        $id = $req->id;
        $payload = $req->all();
        unset($payload['id']);

        $update = $miniAssessmentApi->updateNote($id, $payload);
        if ($update) {
            return response()->json($id);
        }

        return response()->json(false);
    }
}
