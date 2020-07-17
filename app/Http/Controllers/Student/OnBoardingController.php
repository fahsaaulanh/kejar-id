<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Round as RoundApi;
use App\Services\Stage as StageApi;

class OnBoardingController extends Controller
{
    public function index($game, $stageId, $roundId)
    {
        $stageId;
        $roundApi = new RoundApi;
        $round = $roundApi->getDetail($roundId)['data'] ?? [];
        $stageApi = new StageApi;
        $stage = $stageApi->getDetail(strtoupper($game), $stageId)['data'] ?? [];

        $game = $game === 'katabaku' ? 'kata baku' : $game;

        if (count($round) > 0) {
            return view('student.onboardings.index', [
                'round' => $round,
                'stage' => $stage,
                'game' => $game,
            ]);
        }

        abort('404');
    }
}
