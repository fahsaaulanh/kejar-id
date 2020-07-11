<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Stage as StageApi;
use App\Services\Task as TaskApi;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index($game)
    {
        $stageApi = new StageApi();
        $stages = $stageApi->getAll($game)['data'] ?? [];

        $modStages = [];
        foreach ($stages as $stage) {
            $stage['status'] = 'done';
            $modStages[] = $stage;
        }

        $stages = $modStages;

        $taskApi = new TaskApi();

        if ($game == 'OBR') {
            $game = [];
            $game['uri'] = 'OBR';
            $game['title'] = 'Operasi Bilangan Rill';
        } else if($game == 'VOCABULARY'){
            $game = [];
            $game['uri'] = 'VOCABULARY';
            $game['title'] = 'Vocabulary';
        } else if($game == 'KATABAKU'){
            $game = [];
            $game['uri'] = 'KATABAKU';
            $game['title'] = 'Kata Baku';
        }

        return view('student.game.index', compact('game', 'stages'));
    }
}
