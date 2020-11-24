<?php

namespace App\Http\Controllers\Admin;

// use App\Exports\MiniAssessment\ScoreBystudentGroupExport;
use App\Http\Controllers\Controller;
use App\Services\AssessmentGroup as AssessmentGroupApi;
use App\Services\MiniAssessment as miniAssessmentApi;
use App\Services\School as SchoolApi;
// use App\Services\StudentGroup;
use App\Services\Task;
use Exception;
// use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MiniAssessmentController extends Controller
{
    public function schoolId()
    {
        $schoolId = '3da67e44-ca12-4ae8-b784-f066ea605887'; // prod
        $schoolApi = new SchoolApi;
        $subjects = $schoolApi->subjectIndex($schoolId);
        if ($subjects['error']) {
            $schoolId = '73ceaf53-a9d8-4777-92fe-39cb55b6fe3b'; // staging
        }

        return $schoolId;
    }

    public function miniAssessmentGroups($val, $type = 'title')
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

    public function subjects(Request $req, $miniAssessmentGroupValue)
    {

        $schoolId = $this->schoolId();
        $miniAssessmentGroup = $this->miniAssessmentGroups($miniAssessmentGroupValue);

        $schoolApi = new SchoolApi;
        $filter = [
            'page' => ($req->page ?? 1),
            'per_page' => 20,
        ];
        $subjects = $schoolApi->subjectIndex($schoolId, $filter);
        if (!isset($subjects['data'])) {
            $subjects['data'] = [];
        }

        if (!isset($subjects['meta'])) {
            $subjects['meta'] = [];
        }

        return view('admin.mini_assessment_subjects.index')
               ->with('miniAssessmentGroupValue', $miniAssessmentGroupValue)
               ->with('miniAssessmentGroup', $miniAssessmentGroup)
               ->with('subjects', $subjects['data'])
               ->with('subjectMeta', $subjects['meta']);
    }

    public function index(Request $req, $miniAssessmentGroupValue, $subjectId, $grade)
    {
        $schoolId = $this->schoolId();
        $schoolApi = new SchoolApi;
        $miniAssessmentApi = new miniAssessmentApi;
        $group = $this->miniAssessmentGroups($miniAssessmentGroupValue, 'value');
        $filter = [
            'filter[subject_id]' => $subjectId,
            'filter[group]' => $group,
            'filter[grade]' => $grade,
            'page' => ($req->page ?? 1),
            'per_page' => 20,
        ];
        $miniAssessmentIndex = $miniAssessmentApi->index($filter);
        $subject = $schoolApi->subjectDetail($schoolId, $subjectId);


        if (!isset($subject['data'])) {
            return redirect('admin/mini-assessment/'.$miniAssessmentGroupValue)->with(
                ['message' => 'Data Tidak Ditemukan!'],
            );
        }

        if (!isset($miniAssessmentIndex['data'])) {
            $miniAssessmentIndex['data'] = [];
        }

        if (!isset($miniAssessmentIndex['meta'])) {
            $miniAssessmentIndex['meta'] = [];
        }

        return view('admin.mini_assessment_subjects.mini_assessments.index')
               ->with('miniAssessmentGroup', $this->miniAssessmentGroups($miniAssessmentGroupValue))
               ->with('subject', $subject['data'])
               ->with('miniAssessmentGroupValue', $miniAssessmentGroupValue)
               ->with('subjectId', $subjectId)
               ->with('grade', $grade)
               ->with('miniAssessmentIndex', $miniAssessmentIndex['data'])
               ->with('miniAssessmentMeta', $miniAssessmentIndex['meta']);
    }

    public function create(Request $request, $miniAssessmentGroupValue, $subjectId, $grade)
    {
        $payload = [
            'title' => $request['title'],
            'duration' => $request['duration'],
            'subject_id' => $subjectId,
            'grade' => $grade,
            'group' => $this->miniAssessmentGroups($miniAssessmentGroupValue, 'value'),
            'start_time' => $request['start_date'].' '.$request['start_time'],
            'expiry_time' => $request['expiry_date'].' '.$request['expiry_time'],

        ];
        $miniAssessmentApi = new miniAssessmentApi;
        $reqFile = [
            [
                'file_extension' => 'pdf',
                'file' => $request->file('pdf_file'),
                'file_name' => 'sample.pdf',
            ],
        ];
        $create = $miniAssessmentApi->create($reqFile, $payload);

        $payload = [
            'title' => $request['title'],
            'duration' => $request['duration'],
            'subject_id' => $subjectId,
            'grade' => $grade,
            'group' => $this->miniAssessmentGroups($miniAssessmentGroupValue, 'value'),
            'start_time' => $request['start_date'].' '.$request['start_time'],
            'expiry_time' => $request['expiry_date'].' '.$request['expiry_time'],
        ];
        $miniAssessmentApi = new miniAssessmentApi;
        $reqFile = [
            [
                'file_extension' => 'pdf',
                'file' => $request->file('pdf_file'),
                'file_name' => 'sample.pdf',
            ],
        ];
        $create = $miniAssessmentApi->create($reqFile, $payload);

        if ($create) {
            return redirect()->back()->with(['type' => 'success', 'message' => 'Data berhasil tersimpan!']);
        }

        return redirect()->back()->with(['type' => 'danger', 'message' => 'Data gagal tersimpan!']);
    }

    public function update(Request $request)
    {
        $payload = [
            'title' => $request['title'],
            'duration' => $request['duration'],
            'start_time' => $request['start_date'].' '.$request['start_time'],
            'expiry_time' => $request['expiry_date'].' '.$request['expiry_time'],
        ];
        $miniAssessmentApi = new miniAssessmentApi;
        $update = $miniAssessmentApi->update($request['id'], $payload);

        if ($update) {
            return redirect()->back()->with(['type' => 'success', 'message' => 'Data berhasil diperbarui!']);
        }

        return redirect()->back()->with(['type' => 'danger', 'message' => 'Data gagal diperbarui!']);
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
                                        $choices .= '<input type="text" class="form-control txtuppercase"
                                        name="choice['.$v['id'].'][value]" maxlength="1" value="'
                                        .$v['answer'].'" required="" autocomplete="off">';

                                        $choices .= '<input type="hidden" class="form-control"
                                        maxlength="1" name="choice['.$v['id'].'][old]" value="'.$v['answer'].'">';

                                        $choices .= '<input type="hidden" class="form-control"
                                        maxlength="1" name="choice['.$v['id'].'][order]" value="'.$v['order'].'">';

                                        $choices .= '<input type="hidden" class="form-control"
                                        maxlength="1" name="choice['.$v['id'].'][choices_number]"
                                        value="'.$v['choices_number'].'">';

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
                                $multipleChoices .= '<input type="hidden" name="multipleChoice['.$v['id'].'][old]"
                                value="'.implode(',', $v['answer']).'">';

                                $multipleChoices .= '<input type="hidden" class="form-control"
                                maxlength="1" name="multipleChoice['.$v['id'].'][order]" value="'.$v['order'].'">';

                                $multipleChoices .= '<input type="hidden" class="form-control"
                                maxlength="1" name="multipleChoice['.$v['id'].'][choices_number]"
                                value="'.$v['choices_number'].'">';

                    for ($i=0; $i < $v['choices_number']; $i++) {
                        $multipleChoices .= '<div class="col-1 mr-4">';
                            $multipleChoices .= '<div class="form-check">';
                                $multipleChoices .=
                                '<input type="checkbox" name="multipleChoice['.$v['id'].'][value][]"
                                value="'.$this->alphabet($i).'"
                                class="form-check-input mt-2" id="exampleCheck-'.$no.$i.'"';
                        if (in_array($this->alphabet($i), $v['answer'])) {
                                $multipleChoices .= 'checked';
                        }

                                $multipleChoices .= ' >';
                                $multipleChoices .= '<label class="form-check-label ml-2"
                                                    for="exampleCheck-'.$no.$i.'">'
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

    public function uploadAnswers(Request $req)
    {
        $file = $req->file('file');
        try {
            $dataExcel = Excel::toArray([], $file);
            $answers = [];
            foreach ($dataExcel[0] as $key => $v) {
                if ($key < 8 || !$v[0]) {
                    continue;
                }

                $answerOrder = 1;
                foreach ($v as $keyAnswer => $answer) {
                    if ($keyAnswer === 0) {
                        continue;
                    }

                    // Check Choice Number

                    $finalAnswer = strtoupper(str_replace(' ', '', $answer));
                    $countChoice = strlen($finalAnswer);

                    if ($countChoice === 0) {
                        continue;
                    }

                    if ($countChoice > 1) {
                        $finalAnswer = explode(',', $finalAnswer);
                        $countChoice = $finalAnswer[0];
                        unset($finalAnswer[0]);
                        $finalAnswer = array_values($finalAnswer);
                    } else {
                        $countChoice = 5;
                    }

                    $answers[] = [
                        'order' => $answerOrder,
                        'mini_assessment_id' => $v[0],
                        'choices_number' => $countChoice,
                        'answer' => $finalAnswer,
                    ];
                    $answerOrder++;
                }
            }
        } catch (Exception $e) {
            return $e;
        }

        return response()->json($answers);
    }

    public function createAnswers(Request $req)
    {
        $miniAssessmentApi = new miniAssessmentApi;
        $save = $miniAssessmentApi->saveAnswer($req->mini_assessment_id, $req->all());

        return response()->json($save);
    }

    public function editAnswers(Request $req)
    {
        $choices = [];
        $i = 0;
        foreach ($req->choice as $key => $v) {
            if ($v['value'] === $v['old']) {
                continue;
            }

            $choices[$i] = [
                'id' => $key,
                'choices_number' => $v['choices_number'],
                'order' => $v['order'],
                'answer' => $v['value'],
            ];
            $i++;
        }

        foreach ($req->multipleChoice as $key => $v) {
            if (implode(',', $v['value']) === $v['old']) {
                continue;
            }

            $choices[$i] = [
                'id' => $key,
                'choices_number' => $v['choices_number'],
                'order' => $v['order'],
                'answer' => $v['value'],
            ];
            $i++;
        }

        // foreach update jawaban
        $miniAssessmentApi = new miniAssessmentApi;
        foreach ($choices as $payload) {
            $id = $payload['id'];
            unset($payload['id']);
            $miniAssessmentApi->updateAnswer($req->mini_assessment_id, $id, $payload);
        }

        return redirect()->back()->with(
            ['message' => 'Data Berhasil Diperbarui!'],
        );
    }

    public function editSchedule(Request $req)
    {
        $payload = [
            'duration' => $req['duration'],
            'start_time' => $req['start_date'].' '.$req['start_time'],
            'expiry_time' => $req['expiry_date'].' '.$req['expiry_time'],
        ];

        $miniAssessmentApi = new miniAssessmentApi;
        foreach ($req->array as $v) {
            // update
            $miniAssessmentApi->update($v['id'], $payload);
        }

        return response()->json(true);
    }

    public function trackingCode(Request $req)
    {
        $realCode = $req->code;

        if (!$realCode) {
            return response()->json(false);
        }

        if (strlen($realCode) === 44) {
            $realCode = substr($realCode, 4, 36);
        }

        $miniAssessmentApi = new miniAssessmentApi;
        $schoolApi = new SchoolApi;
        $detail = $miniAssessmentApi->detail($realCode);
        if ($detail['error']) {
            return response()->json(false);
        }

        $subject = $schoolApi->subjectDetail($this->schoolId(), $detail['data']['subject_id']);

        $time = $this->dateFormat($detail['data']['start_time'], 'd M Y').
                        '<br> '.$this->dateFormat($detail['data']['start_time'], 'H.i').
                        ' - '.$this->dateFormat($detail['data']['expiry_time'], 'H.i');

        $view = '<div class="row mt-4">';
            $view .= '<div class="col-12">';
                $view .= '<label for="title" class="font-weight-bold">'.$detail['data']['title'].'</label>';
            $view .= '</div>';
        $view .= '</div>';
        $view .= '<div class="row mt-4">';
            $view .= '<div class="col-12">';
                $view .= '<label for="title" class="font-weight-bold">Nama Mapel</label>';
                $view .= '<p>';
                    $link = $req->mini_assessment.'/subject/'.$subject['data']['id'].'/'.$detail['data']['grade'];
                    $view .= '<a target="_blank"
                    href="/admin/mini-assessment/'.$link.'">';
                        $view .= $subject['data']['name'];
                    $view .= '</a>';
                $view .= '</p>';
            $view .= '</div>';
        $view .= '</div>';
        $view .= '<div class="row mt-4">';
            $view .= '<div class="col-12">';
                $view .= '<label for="title" class="font-weight-bold">Kelas</label>';
                $view .= '<p>' .$detail['data']['grade']. '</p>';
            $view .= '</div>';
        $view .= '</div>';
        $view .= '<div class="row mt-4">';
            $view .= '<div class="col-12">';
                $view .= '<label for="title" class="font-weight-bold">Waktu Pelaksanaan</label>';
                $view .= '<p>'.$time.'</p>';
            $view .= '</div>';
        $view .= '</div>';
        $view .= '<div class="row mt-4">';
            $view .= '<div class="col-12">';
                $view .= '<label for="title" class="font-weight-bold">Durasi</label>';
                $view .= '<p>' .$detail['data']['duration']. ' menit</p>';
            $view .= '</div>';
        $view .= '</div>';
        $view .= '<div class="row mt-5">';
            $view .= '<div class="col-12">';
                $view .= '<div class="alert alert-primary" role="alert" id="link-package">';
                    $view .= '<a href="'.$detail['data']['pdf'].'"
                    target="_blank"><i class="kejar-pdf text-primary"></i> Lihat Naskah Soal</a>';
                $view .= '</div>';
            $view .= '</div>';
        $view .= '</div>';

        return response()->json(['view' => $view, 'code' => $detail['data']['id']]);
    }

    public function export()
    {
        $taskService = new Task;
        $grade = $this->request->input('grade');
        $subjectId = $this->request->input('subject_id', null);

        if ($subjectId === null) {
            return redirect()->back();
        }

        $filter = [
            'filter[grade]' => $grade,
        ];

        $response = $taskService->reportMiniAssessmentForAdmin($subjectId, $filter);

        if (!$response['error']) {
            return redirect($response['data']);
        }

        return redirect()->back()->with('message', $response['message']);
    }
}
