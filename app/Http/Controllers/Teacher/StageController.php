<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Services\Batch as BatchApi;
use App\Services\Game;
use App\Services\School;
use App\Services\Stage as StageApi;
use App\Services\StudentGroup as StudentApi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class StageController extends Controller
{

    public function index($game)
    {
        $schoolId = session('user')['userable']['school_id'];
        $entryYear = Carbon::now()->year . '/' . Carbon::now()->add(1, 'year')->year;
        $secondYear = Carbon::now()->sub(1, 'year')->year . '/' . Carbon::now()->year;
        $thirdYear = Carbon::now()->sub(1, 'year')->year . '/' . Carbon::now()->sub(2, 'year')->year;

        $year = [$entryYear, $secondYear, $thirdYear];
        $batchApi = new BatchApi;

        $batchResult = [];
        foreach ($year as $data) {
            $batchFilter = [
                'filter[entry_year]' => $data,
            ];
            $batchResponse = $batchApi->index($schoolId, $batchFilter);

            $batchResult = array_merge($batchResult, $batchResponse['data'] ?? []);
        }

        $gameService = new Game;
        $game = $gameService->parse($game);
        $classApi = new StudentApi;

        $classResult = [];
        foreach ($batchResult as $data) {
            $classResponse = $classApi->index($schoolId, $data['id']);
            $classResult = array_merge($classResult, $classResponse['data'] ?? []);
        }

        $schoolService = new School;
        $school = $schoolService->detail($schoolId);
        $classData = $classResult ?? [];
        $classList = [];
        $educational = $school['data']['educational_stage'];

        if ($educational === 'SMP') {
            $classGrade = ['7', '8', '9'];
            $classCount = [
                'count_7' => 0,
                'count_8' => 0,
                'count_9' => 0,
            ];
            
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

                usort(
                    $classList,
                    fn ($str1, $str2) => strnatcmp($str1['class_name'], $str2['class_name']),
                );

                foreach ($classList as $class) {
                    if ($class['class_grade'] === '7') {
                        $classCount['count_7'] += 1;
                    } elseif ($class['class_grade'] === '8') {
                        $classCount['count_8'] += 1;
                    } else {
                        $classCount['count_9'] += 1;
                    }
                }
            }
        } else {
            $classGrade = ['X', 'XI', 'XII'];
            $classCount = [
                'count_x' => 0,
                'count_xi' => 0,
                'count_xii' => 0,
            ];

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

                usort(
                    $classList,
                    fn ($str1, $str2) => strnatcmp($str1['class_name'], $str2['class_name']),
                );

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
        }

        return view('teacher.stages.index', compact('game', 'classList', 'classCount', 'educational'));
    }

    public function resultStage(Request $request, $game, $batchId, $studentGroupId)
    {
        $stageApi = new StageApi;
        $linkGame = $game;
        $gameService = new Game;
        $game = $gameService->parse($game);

        $page = $request->input('page', null);
        if ($page === null) {
            $page = 1;
        }

        //Get Student and result
        $filter = [
            'filter[game]' => strtoupper($game['uri']),
            'page' => $page,
            'per_page' => 15,
        ];

        $data = $stageApi->getResult($studentGroupId, $filter) ?? [];
        $cn = $data['data'][0]['progress'];

        //get data studentGroup
        $studentGroupApi = new StudentApi;
        $schoolId = $data['data'][0]['school_id'];
        $dataStudentGroups = $studentGroupApi->index($schoolId, $batchId);
        $classData = $dataStudentGroups['data'] ?? [];
        $classThis = [];

        foreach ($classData as $class) {
            if ($class['id'] === $studentGroupId) {
                $classThis = $class;
            }
        }

        $thisYear = date('Y');
        $thisGrade = '1' . ($thisYear - substr($classThis['school_year'], 0, 4));

        if ($thisYear < substr($classThis['school_year'], 0, 4)) {
            $thisGrade = '12';
        }

        $thisClass = [];
        $thisClass[0] = $thisGrade;
        $thisClass[1] = $classThis;

        $responses = $this
            ->myPaginate($data['data'], $data['meta']['per_page'], $data['meta']['current_page'], $data['meta'])
            ->withPath('/teacher/games/' . $linkGame . '/class/' . $batchId . '/' . $studentGroupId . '/stages');

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

        return new LengthAwarePaginator($data, $options['total'], $perPage, $page, $options);
    }
}
