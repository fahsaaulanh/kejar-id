<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MiniAssessment as miniAssessmentApi;
use App\Services\School as SchoolApi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MiniAssessmentController extends Controller
{
    public function schoolId()
    {
        // return '73ceaf53-a9d8-4777-92fe-39cb55b6fe3b'; // staging
        return '3da67e44-ca12-4ae8-b784-f066ea605887'; // prod
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
                                '<input type="checkbox" class="form-check-input mt-2" id="exampleCheck1"';
                        if (in_array($this->alphabet($i), $v['answer'])) {
                                $multipleChoices .= 'checked';
                        }

                                $multipleChoices .= ' >';
                                $multipleChoices .= '<label class="form-check-label ml-2" for="exampleCheck1">'
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
}
