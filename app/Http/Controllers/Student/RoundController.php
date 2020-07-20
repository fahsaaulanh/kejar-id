<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Round as RoundApi;
use App\Services\Stage as StageApi;
use App\Services\User as UserApi;

class RoundController extends Controller
{
    public function index($game, $stageId)
    {
        $stageApi = new StageApi;
        $response = $stageApi->getDetail(strtoupper($game), $stageId);
        $stage = $response['data'];

        $roundApi = new RoundApi;
        $filter = [
            'filter[stage_id]' => $stageId,
            'filter[status]' => 'PUBLISHED',
            'per_page' => 99,
        ];
        $response = $roundApi->index($filter);


        $data = $response['data'] ?? [];

        $rounds = [];
        if ($data !== []) {
            foreach ($data as $key => $round) {
                $userApi = new UserApi;
                $filter = [
                    'filter[taskable_id]' => $round['id'],
                    'filter[finished]' => 'true',
                    'filter[taskable_type]' => 'MATRIKULASI',
                    'per_page' => 99,
                ];
                $result = $userApi->meTask($filter);
                $score = null;

                if ($result['error'] === false && $result['data'] !== null) {
                    $score = $result['data']['0']['score'];
                }

                $rounds[$key]['id'] = $round['id'];
                $rounds[$key]['stage_id'] = $round['stage_id'];
                $rounds[$key]['description'] = $round['description'];
                $rounds[$key]['direction'] = $round['direction'];
                $rounds[$key]['material'] = $round['material'];
                $rounds[$key]['total_question'] = $round['total_question'];
                $rounds[$key]['question_timespan'] = $round['question_timespan'];
                $rounds[$key]['order'] = $round['order'];
                $rounds[$key]['status'] = $round['status'];
                $rounds[$key]['title'] = $round['title'];
                $rounds[$key]['score'] = $score;
            }
        }

        if ($rounds !== '') {
            $round = [];
            foreach ($rounds as $key => $row) {
                $round[$key] = $row['order'];
            }

            array_multisort($round, SORT_ASC, $rounds);
        } else {
            $rounds = '';
        }

        if ($game === 'obr') {
            $game = ['short' => 'OBR', 'title' => 'Operasi Bilangan Rill', 'uri' => 'obr'];
        } elseif ($game === 'vocabulary') {
            $game = ['short' => 'Vocabulary', 'title' => 'VOCABULARY', 'uri' => 'vocabulary'];
        } elseif ($game === 'katabaku') {
            $game = ['short' => 'Kata Baku', 'title' => 'KATA BAKU', 'uri' => 'katabaku'];
        } else {
            abort(404);
        }

        return view('student.rounds.index', compact('game', 'stage', 'rounds'));
    }
}
