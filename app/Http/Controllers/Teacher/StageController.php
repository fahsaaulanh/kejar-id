<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Services\Batch as BatchApi;
use App\Services\Game;
use App\Services\Stage as StageApi;
use App\Services\StudentGroup as StudentApi;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class StageController extends Controller
{

    public function index($game)
    {
        $schoolId = session('user')['userable']['school_id'];
        $entryYear = Carbon::now()->year . '/' . Carbon::now()->add(1, 'year')->year;
        $batchApi = new BatchApi;
        $batchFilter = [
            'filter[entry_year]' => $entryYear,
        ];
        $batchResponse = $batchApi->index($schoolId, $batchFilter);
        $batchId = $batchResponse['data'][0]['id'];
        $gameService = new Game;
        $game = $gameService->parse($game);
        $classApi = new StudentApi;
        $classResponse = $classApi->index($schoolId, $batchId);
        $classData = $classResponse['data'] ?? [];
        $classGrade = ['X', 'XI', 'XII'];
        $classCount = [
            'count_x' => 0,
            'count_xi' => 0,
            'count_xii' => 0,
        ];
        $classList = [];
        $number = 0;
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

            foreach ($classList as $class) {
                if ($class['class_grade'] === 'X') {
                    $classCount['count_x'] += 1;
                } elseif ($class['class_grade'] === 'XI') {
                    $classCount['count_xi'] += 1;
                } else {
                    $classCount['count_xii'] += 1;
                }
            }
        }

        return view('teacher.stages.index', compact('game', 'classList', 'classCount'));
    }

    public function resultStage($game, $batchId, $studentGroupId)
    {
        $stageApi = new StageApi;
        $linkGame = $game;
        $gameService = new Game;
        $game = $gameService->parse($game);

        //Get Student and result
        $filter = [
            'filter[game]' => strtoupper($game['uri']),
            'per_page' => 99,
        ];

        $data = $stageApi->getResult($studentGroupId, $filter)['data'] ?? [];
        $cn = $data[0]['progress'];

        //get data studentGroup
        $studentGroupApi = new StudentApi;
        $schoolId = $data[0]['school_id'];
        $dataStudentGroups = $studentGroupApi->index($schoolId, $batchId);
        $classData = $dataStudentGroups['data'] ?? [];
        $classThis = [];

        foreach ($classData as $class) {
            if ($class['id'] === $studentGroupId) {
                $classThis = $class;
            }
        }

        $thisGrade = substr(explode(' ', $classThis['name'])[1], 0, strlen(explode(' ', $classThis['name'])[1])-2);

        $thisClass = [];
        $thisClass[0] = $thisGrade;
        $thisClass[1] = $classThis;

        $responses = $this->myPaginate($data)
        ->withPath('/teacher/games/'.$linkGame.'/class/'.$batchId.'/'.$studentGroupId.'/stages');

        return view('teacher/result/stage/index', compact(
            'game',
            'responses',
            'cn',
            'dataStudentGroups',
            'studentGroupId',
            'batchId',
            'thisClass',
        ));
    }

    private function myPaginate($data, $perPage = 20, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $data = $data instanceof Collection ? $data : Collection::make($data);

        return new LengthAwarePaginator($data->forPage($page, $perPage), $data->count(), $perPage, $page, $options);
    }
}
