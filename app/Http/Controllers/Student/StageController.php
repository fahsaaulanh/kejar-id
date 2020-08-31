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

        $rounds = $roundApi->index(['filter[status]' => 'PUBLISHED'])['data'] ?? [];
        $stageIds = [];
        foreach ($rounds as $round) {
            $stageIds[] = $round['stage_id'];
        }

        $stageIds = array_unique($stageIds);

        $filter = [
            'per_page' => 99,
        ];
        $stagesAll = $stagesApi->getAll($game, $filter)['data'] ?? [];

        $stages = [];
        foreach ($stagesAll as $stage) {
            if (in_array($stage['id'], $stageIds, true)) {
                $stages[] = $stage;
            }
        }

        $game = $gameService->parse($game);

        return view('student.stages.index', compact('game', 'stages'));
    }
}
