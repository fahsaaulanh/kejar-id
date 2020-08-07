<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Game;
use App\Services\Stage as StageApi;

class StageController extends Controller
{
    public function index($game)
    {
        $game = strtoupper($game);
        $stagesApi = new StageApi;
        $gameService = new Game;

        $filter = [
            'per_page' => 99,
        ];
        $stages = $stagesApi->getAll($game, $filter)['data'] ?? [];

        $game = $gameService->parse($game);

        return view('student.stages.index', compact('game', 'stages'));
    }
}
