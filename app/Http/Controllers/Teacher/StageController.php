<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Services\Batch as BatchApi;
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

        $game = $this->getGame($game);
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
        $game = $this->getGame($game);

        //Get Student and result
        $filter = [
            'filter[game]' => strtoupper($game['uri']),
        ];
        $data = $stageApi->getResult($studentGroupId, $filter)['data'] ?? [];
        $cn = count($data[0]['progress']);

        //get data studentGroup
        $studentGroupApi = new StudentApi;
        $schoolId = $data[0]['school_id'];
        $dataStudentGroups = $studentGroupApi->index($schoolId, $batchId);

        $responses = $this->myPaginate($data)->withPath('/teacher/games/'.$linkGame.'/class/'.$studentGroupId.'/stage');
        
        return view('teacher/result/stage/index', compact('game', 'responses', 'cn', 'dataStudentGroups'));
    }

    private function myPaginate($data, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $data = $data instanceof Collection ? $data : Collection::make($data);

        return new LengthAwarePaginator($data->forPage($page, $perPage), $data->count(), $perPage, $page, $options);
    }

    private function getGame($game)
    {
        $game = strtolower($game);

        if ($game === 'obr') {
            $game = [];
            $game['uri'] = 'obr';
            $game['short'] = 'OBR';
            $game['title'] = 'Operasi Bilangan Rill';
            $game['result'] = 'ronde';
        } elseif ($game === 'vocabulary') {
            $game = [];
            $game['uri'] = 'vocabulary';
            $game['short'] = 'Vocabulary';
            $game['title'] = 'VOCABULARY';
            $game['result'] = 'words';
        } elseif ($game === 'katabaku') {
            $game = [];
            $game['uri'] = 'katabaku';
            $game['short'] = 'Kata Baku';
            $game['title'] = 'KATA BAKU';
            $game['result'] = 'kata';
        } else {
            abort(404);
        }

        return $game;
    }
}
