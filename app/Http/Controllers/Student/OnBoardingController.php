<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Round as RoundApi;
use App\Services\Stage as StageApi;
use Illuminate\Http\Request;

class OnBoardingController extends Controller
{
    public function index($game, $stageId, $roundId)
    {
        $roundApi = new RoundApi();
        $round = $roundApi->getDetail($roundId)['data'] ?? [];
        $stageApi = new StageApi();
        $stage = $stageApi->getDetail($game, $round['stage_id'])['data'] ?? [];

        $game = $game == 'KATABAKU' ? 'KATA BAKU' : $game;

        if(count($round) > 0){
            return view('student.onboarding.index', [
                'round' => $round,
                'stage' => $stage,
                'game' => $game,
            ]);
        }

        abort('404');

    }
}
