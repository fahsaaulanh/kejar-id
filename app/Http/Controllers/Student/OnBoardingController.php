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

        if (count($round) > 0) {
            return view('student.onboardings.index', [
                'round' => $round,
                'stage' => $stage,
                'game' => $this->getGame($game),
            ]);
        }

        abort('404');
    }

    private function getGame($game)
    {
        switch ($game) {
            case 'obr':
                return 'OBR';

                break;
            case 'vocabulary':
                return 'Vocabulary';

                break;
            case 'katabaku':
                return 'Kata Baku';

                break;
            default:
                return $game;

                break;
        }
    }
}
