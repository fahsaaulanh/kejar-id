<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Stage as StageApi;

class StageController extends Controller
{
    public function index($game)
    {
        $stageApi = new StageApi;

        $stages = $stageApi->getAll(strtoupper($game))['data'] ?? [];

        $modStages = [];
        foreach ($stages as $stage) {
            $stage['status'] = 'done';
            $modStages[] = $stage;
        }

        $stages = $modStages;
        
        if ($game === 'obr') {
            $game = [];
            $game['uri'] = 'obr';
            $game['title'] = 'Operasi Bilangan Rill';
        } elseif ($game === 'vocabulary') {
            $game = [];
            $game['uri'] = 'vocabulary';
            $game['title'] = 'Vocabulary';
        } elseif ($game === 'katabaku') {
            $game = [];
            $game['uri'] = 'katabaku';
            $game['title'] = 'Kata Baku';
        }

        return view('student.stages.index', compact('game', 'stages'));
    }
}
