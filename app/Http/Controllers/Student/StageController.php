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
                    $modStages[] = $stage;
                } else {
                    $stage['status'] = 'NOT FINISHED';
                }
            } else {
                $stage['status'] = 'NOT FINISHED';
                $modStages[] = $stage;
            }
        }

        $stages = $modStages;

        $game = $this->getGame($game);

        return view('student.stages.index', compact('game', 'stages'));
    }

    private function getGame($game)
    {
        if ($game === 'obr') {
            $game = [
                'short' => 'OBR',
                'title' => 'Operasi Bilangan Rill',
                'uri' => 'obr',
            ];
        } elseif ($game === 'vocabulary') {
            $game = [
                'short' => 'Vocabulary',
                'title' => 'Vocabulary',
                'uri' => 'vocabulary',
            ];
        } elseif ($game === 'katabaku') {
            $game = [
                'short' => 'Kata Baku',
                'title' => 'Kata Baku',
                'uri' => 'katabaku',
            ];
        } else {
            abort(404);
        }

        return $game;
    }
}
