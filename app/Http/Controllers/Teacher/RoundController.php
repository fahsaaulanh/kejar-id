<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Services\Batch as BatchApi;
use App\Services\Game;
use App\Services\Report as ReportApi;
use App\Services\Round as RondeApi;
use App\Services\Stage as StageApi;
use App\Services\StudentGroup as StudentApi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoundController extends Controller
{

    public function index(Request $request, $game, $batchId, $studentGroupId, $stageId)
    {
        $batchId;
        $game = strtoupper($game);
        $reportRoundApi = new ReportApi;
        $students = $reportRoundApi->roundReport($studentGroupId, $stageId, $request->page ?? 1);

        $stageApi = new StageApi;
        $stageFilter = [
            'per_page' => 99,
        ];
        $stageDetailResponse = $stageApi->getDetail($game, $stageId);
        $stageAllResponse = $stageApi->getAll($game, $stageFilter);
        $stage = $stageDetailResponse['data'] ?? [];
        $stageData = $stageAllResponse['data'] ?? [];

        $gameService = new Game;
        $game = $gameService->parse($game);

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

    public function modal($game, $batchId, $studentGroupId, $studentId)
    {
        $batchId;

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

        return response()->json(['student' => $student]);
    }

    public function description($game, $batchId, $studentGroupId, $stageId, $roundId)
    {
        $batchId;
        $studentGroupId;
        $gameService = new Game;
        $game = $gameService->parse($game);
        $stageApi = new StageApi;
        $stage = $stageApi->getDetail(strtoupper($game['uri']), $stageId)['data'] ?? [];
        $roundApi = new RondeApi;
        $round = $roundApi->getDetail($roundId)['data'] ?? [];

        return view('teacher/rounds/_detail_round', compact('stage', 'round', 'game'));
    }
}
