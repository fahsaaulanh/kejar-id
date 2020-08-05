<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Game;
use App\Services\Round as RoundApi;
use App\Services\Stage as StageApi;
use App\Services\User as UserApi;

class StageController extends Controller
{
    public function index($game)
    {
        $game = strtoupper($game);
        $stagesApi = new StageApi;
        $userApi = new UserApi;
        $roundApi = new RoundApi;
        $gameService = new Game;

        $filter = [
            'per_page' => 99,
        ];
        $stages = $stagesApi->getAll($game, $filter)['data'] ?? [];

        $modStages = [];
        foreach ($stages as $stage) {
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
                    $modStages[] = $stage;
                } else {
                    $stage['status'] = 'NOT FINISHED';
                }
            } else {
                $stage['status'] = 'NOT FINISHED';
                $modStages[] = $stage;
            }
        }

        $game = $gameService->parse($game);
        $stages = $modStages;

        return view('student.stages.index', compact('game', 'stages'));
    }
}
