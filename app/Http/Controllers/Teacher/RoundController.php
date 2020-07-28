<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Services\Batch as BatchApi;
use App\Services\Report as ReportApi;
use App\Services\RoundQuestion;
use App\Services\Stage as StageApi;
use App\Services\StudentGroup as StudentApi;
// use App\Services\Question as QuestionApi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoundController extends Controller
{

    public function index(Request $request, $game, $batchId, $studentGroupId, $stageId)
    {
        $batchId;
        $reportRoundApi = new ReportApi;
        $students = $reportRoundApi->roundReport($studentGroupId, $stageId, $request->page ?? 1);

        $stageApi = new StageApi;
        $game = strtoupper($game);
        $stageFilter = [
            'per_page' => 99,
        ];

        $stageDetailResponse = $stageApi->getDetail($game, $stageId);
        $stageAllResponse = $stageApi->getAll($game, $stageFilter);
        $stage = $stageDetailResponse['data'] ?? [];
        $stageData = $stageAllResponse['data'] ?? [];
        $game = strtolower($game);
        $game = $this->getGame($game);

        $schoolId = session('user')['userable']['school_id'];
        $entryYear = Carbon::now()->year . '/' . Carbon::now()->add(1, 'year')->year;
        $batchApi = new BatchApi;
        $batchFilter = [
            'filter[entry_year]' => $entryYear,
        ];
        $batchResponse = $batchApi->index($schoolId, $batchFilter);
        $batchId = $batchResponse['data'][0]['id'];

        $studentGroupApi = new StudentApi;
        $classResponse = $studentGroupApi->index($schoolId, $batchId);
        $classData = $classResponse['data'] ?? [];
        $classGrade = ['X', 'XI', 'XII'];
        $classGroup = [];
        $classList = [];
        $classThis = [];
        $thisGrade = '';
        $number = 0;
        $index = 0;

        if (count($classData) !== 0) {
            foreach ($classData as $data) {
                if (stripos($data['name'], $classGrade[2]) !== false) {
                    $classList[$number] = [
                        'class_id' => $data['id'],
                        'class_batch_id' => $data['batch_id'],
                        'class_grade' => $classGrade[2],
                        'class_name' => $data['name'],
                        'class_school_year' => $data['school_year'],
                    ];
                    $number += 1;
                } elseif (stripos($data['name'], $classGrade[1]) !== false) {
                    $classList[$number] = [
                        'class_id' => $data['id'],
                        'class_batch_id' => $data['batch_id'],
                        'class_grade' => $classGrade[1],
                        'class_name' => $data['name'],
                        'class_school_year' => $data['school_year'],
                    ];
                    $number += 1;
                } else {
                    $classList[$number] = [
                        'class_id' => $data['id'],
                        'class_batch_id' => $data['batch_id'],
                        'class_grade' => $classGrade[0],
                        'class_name' => $data['name'],
                        'class_school_year' => $data['school_year'],
                    ];
                    $number += 1;
                }
            }

            $order = [];
            foreach ($classList as $key => $row) {
                $order[$key] = $row['class_name'];
            }

            array_multisort($order, SORT_ASC, $classList);

            foreach ($classData as $class) {
                if ($class['id'] === $studentGroupId) {
                    $classThis = $class;
                }
            }

            $thisGrade = substr(explode(' ', $classThis['name'])[1], 0, strlen(explode(' ', $classThis['name'])[1])-2);

            foreach ($classList as $class) {
                if ($class['class_grade'] === $thisGrade) {
                    $classGroup[] = $class;
                }
            }

            foreach ($stageData as $key => $value) {
                if ($value['id'] === $stage['id']) {
                    $index = $key;

                    break;
                }
            }
        }

        $thisClass = [];
        $thisClass[0] = $thisGrade;
        $thisClass[1] = $classThis;

        $before = $stageData[$index - 1] ?? null;
        $current = $stageData[$index] ?? null;
        $after = $stageData[$index + 1] ?? null;
        $pages = [$before, $current, $after];

        return view('teacher/rounds/index', compact(
            'game',
            'batchId',
            'pages',
            'stage',
            'students',
            'thisClass',
            'classGroup',
        ));
    }

    // TO DO Delete this if not being used
    // public function modalView($game, $studentGroupId)
    // {
    //     $game = strtolower($game);
    //     $game = $this->getGame($game);

    //     return view('teacher/rounds/modal', compact('game', 'studentGroupId'));
    // }

    public function modal($game, $studentGroupId, $studentId)
    {
        $reportStageApi = new ReportApi;
        $game = strtoupper($game);
        $gameFilter = [
            'filter[game]' => $game,
        ];
        $studentStageData = $reportStageApi->stageReport($studentGroupId, $gameFilter)['data'];
        $student = [];

        foreach ($studentStageData as $data) {
            if ($data['id'] === $studentId) {
                $student = $data;
            }
        }

        // $stages = $student['progress'];

        foreach ($student['progress'] as $key1 => $stage) {
            $reportRoundApi = new ReportApi;
            $studentRoundData = $reportRoundApi->roundReport($studentGroupId, $stage['stage_id'])['data'] ?? [];

            foreach ($studentRoundData as $round) {
                if ($round['id'] === $studentId) {
                    $finishedRound = 0;
                    $student['progress'][$key1]['rounds'] = $round['progress'];

                    foreach ($round['progress'] as $key2 => $roundQuestion) {
                        $roundQuestionApi = new RoundQuestion;
                        $questions = $roundQuestionApi->getAll($roundQuestion['round_id'])['data'] ?? [];
                        $student['progress'][$key1]['rounds'][$key2]['round_question'] = $questions;
                        $finishedRound += $roundQuestion['is_done'] === true ? 1 : 0;

                        // foreach ($questions as $key3 => $question) {
                        //     $taskApi = new QuestionApi;
                        //     $tasks = $taskApi->getDetail($question['question_id']);
                        //     $student['progress'][$key1]['rounds'][$key2]['questions'][$key3]['tasks'] = $tasks;
                        // }
                    }

                    $student['progress'][$key1]['finished_round'] = $finishedRound;
                    $student['progress'][$key1]['total_round'] = count($round['progress']);
                }
            }
        }

        // Only take question data for counting finished question

        return response()->json(['student' => $student]);
    }

    private function getGame($game)
    {
        $game = strtolower($game);

        if ($game === 'obr') {
            $game = [];
            $game['uri'] = 'obr';
            $game['short'] = 'OBR';
            $game['title'] = 'Operasi Bilangan Rill';
        } elseif ($game === 'vocabulary') {
            $game = [];
            $game['uri'] = 'vocabulary';
            $game['short'] = 'Vocabulary';
            $game['title'] = 'VOCABULARY';
        } elseif ($game === 'katabaku') {
            $game = [];
            $game['uri'] = 'katabaku';
            $game['short'] = 'Kata Baku';
            $game['title'] = 'KATA BAKU';
        } else {
            abort(404);
        }

        return $game;
    }
}
