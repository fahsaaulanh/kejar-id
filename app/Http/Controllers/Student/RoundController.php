<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Game;
use App\Services\Round as RoundApi;
use App\Services\Stage as StageApi;
use App\Services\User as UserApi;

class RoundController extends Controller
{
    public function index($game, $stageId)
    {
        $game = strtoupper($game);
        $stageApi = new StageApi;
        $response = $stageApi->getDetail($game, $stageId);
        $stage = $response['data'];
        $gameService = new Game;

        $game = $gameService->parse($game);

        return view('student.rounds.index', compact('game', 'stage'));
    }

    public function getIndex($game, $stageId)
    {
        $game;
        $roundApi = new RoundApi;
        $userApi = new UserApi;

        $filter = [
            'filter[stage_id]' => $stageId,
            'filter[status]' => 'PUBLISHED',
            'per_page' => 99,
        ];

        $rounds = $roundApi->index($filter)['data'] ?? [];

        $responseRounds = [];
        foreach ($rounds as $key => $round) {
            $filter = [
                'filter[taskable_id]' => $round['id'],
                'filter[finished]' => 'true',
                'filter[taskable_type]' => 'MATRIKULASI',
                'per_page' => 99,
            ];

            $score = $userApi->meTask($filter)['data'] ?? [];

            $responseRounds[$key]['id'] = $round['id'];
            $responseRounds[$key]['title'] = $round['title'];
            $responseRounds[$key]['order'] = $round['order'];
            $responseRounds[$key]['score'] = $score[0]['score'] ?? null;
        }

        usort($responseRounds, fn ($a, $b) => $a['order'] <=> $b['order']);

        return response()->json(['error' => false, 'data' => $responseRounds]);
    }
}
