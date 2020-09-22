<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Game;
use App\Services\Round;
use App\Services\Stage as StageApi;

class StageController extends Controller
{
    public function index($game)
    {
        $game = strtoupper($game);
        $stagesApi = new StageApi;
        $gameService = new Game;
        $roundApi = new Round;

        $filter = [
            'per_page' => 99,
        ];
        $stagesAll = $stagesApi->getAll($game, $filter)['data'] ?? [];

        $stages = [];
        foreach ($stagesAll as $stage) {
            $filter = [
                'per_page' => 1,
                'filter[status]' => 'PUBLISHED',
                'filter[stage_id]' => $stage['id'],
            ];
            $rounds = $roundApi->index($filter);

            if ($rounds['error'] !== false && $rounds['data'] === null) {
                continue;
            }

            $stages[] = $stage;
        }

        $game = $gameService->parse($game);

        return view('student.stages.index', compact('game', 'stages'));
    }
}
