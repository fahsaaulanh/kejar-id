<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Round as RoundApi;
use App\Services\Stage as StageApi;

class RoundController extends Controller
{
    // Open View User Round
    public function index($game, $stageId)
    {
        $stageApi = new StageApi;
        $response = $stageApi->getDetail($game, $stageId);
        $stage = $response['data'];

        $roundApi = new RoundApi;
        $filter = `?filter[stage_id]=$stageId`;
        $response = $roundApi->index($filter);

        $rounds = $response['data'] ?? [];

        if ($rounds !== '') {
            $round = [];
            foreach ($rounds as $key => $row) {
                $round[$key] = $row['order'];
            }

            array_multisort($round, SORT_ASC, $rounds);
        } else {
            $rounds = '';
        }

        if ($game === 'OBR') {
            $game = ['short' => 'OBR', 'title' => 'Operasi Bilangan Rill', 'uri' => 'OBR'];
        } elseif ($game === 'VOCABULARY') {
            $game = ['short' => 'Vocabulary', 'title' => 'VOCABULARY', 'uri' => 'VOCABULARY'];
        } elseif ($game === 'KATABAKU') {
            $game = ['short' => 'Kata Baku', 'title' => 'KATA BAKU', 'uri' => 'KATABAKU'];
        } else {
            abort(404);
        }

        return view('student.round.index', compact('game', 'stage', 'rounds'));
    }
}
