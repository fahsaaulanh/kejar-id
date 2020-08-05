<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Game;
use App\Services\Round as RoundApi;
use App\Services\Stage as StageApi;

class OnBoardingController extends Controller
{
    public function index($game, $stageId, $roundId)
    {
        $game = strtoupper($game);
        $stageId;
        $roundApi = new RoundApi;
        $round = $roundApi->getDetail($roundId)['data'] ?? [];
        $stageApi = new StageApi;
        $stage = $stageApi->getDetail(strtoupper($game), $stageId)['data'] ?? [];
        $gameService = new Game;
        $game = $gameService->parse($game);

        if (count($round) > 0) {
            return view('student.onboardings.index', [
                'round' => $round,
                'stage' => $stage,
                'game' => $game['short'],
            ]);
        }

        abort('404');
    }
}
