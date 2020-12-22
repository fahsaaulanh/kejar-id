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
        $gameService = new Game;
        $game = $gameService->parse($game);

        return view('student.stages.index', compact('game'));
    }

    public function getIndex($game)
    {
        $game = strtoupper($game);
        $stagesApi = new StageApi;

        $filter = [
            'per_page' => 99,
        ];

        $stages = $stagesApi->getAll($game, $filter)['data'] ?? [];

        return response()->json(['error' => false, 'data' => $stages]);
    }

    public function stageStatus($game, $stageId)
    {
        $game;
        $roundsApi = new Round;

        $filter = [
            'per_page' => 1,
            'filter[status]' => 'PUBLISHED',
            'filter[stage_id]' => $stageId,
        ];
        $rounds = $roundsApi->index($filter)['data'] ?? [];

        $message = [
            'status' => count($rounds) > 0,
        ];

        return response()->json($message);
    }
}
