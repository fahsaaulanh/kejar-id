<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Round as RoundApi;
use App\Services\Stage as StageApi;
use App\Services\User as UserApi;

class StageController extends Controller
{
    public function index($game)
    {
        $stagesApi = new StageApi;
        $filter = [
            'per_page' => 99,
        ];
        $stages = $stagesApi->getAll(strtoupper($game), $filter)['data'] ?? [];

        $modStages = [];
        foreach ($stages as $stage) {
            $roundApi = new RoundApi;
            $filter = [
                'filter[stage_id]' => $stage['id'],
                'filter[status]' => 'PUBLISHED',
                'per_page' => 99,
            ];
            $response = $roundApi->index($filter);
            $data = $response['data'] ?? [];

            $taskCompletedCount = 0;
            $totalTaskCount = 0;

            foreach ($data as $round) {
                $userApi = new UserApi;
                $filter = [
                    'filter[taskable_id]' => $round['id'],
                    'filter[finished]' => 'true',
                    'filter[taskable_type]' => 'MATRIKULASI',
                    'per_page' => 99,
                ];
                $taskCompleted = $userApi->meTask($filter);

                if ($taskCompleted['error'] === false && $taskCompleted['data'] !== null) {
                    $taskCompletedCount += 1;
                }

                $totalTaskCount += 1;
            }
            
            if ($taskCompletedCount === $totalTaskCount) {
                if ($totalTaskCount !== 0) {
                    $stage['status'] = 'DONE';
                }
            } else {
                $stage['status'] = 'NOT FINISHED';
            }

            $modStages[] = $stage;
        }

        $stages = $modStages;

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

        return view('student.stages.index', compact('game', 'stages'));
    }
}
