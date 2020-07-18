<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Stage as StageApi;

class StageController extends Controller
{
    public function index($game)
    {
        $stageApi = new StageApi;

        $filter = [
            'per_page' => 99,
        ];

        $stages = $stageApi->getAll(strtoupper($game), $filter)['data'] ?? [];

        $modStages = [];
        foreach ($stages as $stage) {
            $stage['status'] = 'done';
            $modStages[] = $stage;
        }

        $stages = $modStages;

        if ($game === 'obr') {
            $game = [];
            $game['uri'] = 'obr';
            $game['short'] = 'OBR';
            $game['title'] = 'Operasi Bilangan Rill';
        } elseif ($game === 'vocabulary') {
            $game = [];
            $game['uri'] = 'vocabulary';
            $game['title'] = 'Vocabulary';
            $game['short'] = 'Vocabulary';
        } elseif ($game === 'katabaku') {
            $game = [];
            $game['uri'] = 'katabaku';
            $game['title'] = 'Kata Baku';
            $game['short'] = 'Vocabulary';
        }

        return view('student.stages.index', compact('game', 'stages'));
    }
}
