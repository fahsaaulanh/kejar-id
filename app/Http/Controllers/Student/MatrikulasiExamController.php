<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Game;
use App\Services\Round as RoundApi;
use App\Services\Task as TaskApi;
use Illuminate\Http\Request;
use Throwable;

class MatrikulasiExamController extends Controller
{

    public function index($game, $stageId, $roundId)
    {

        $taskApi = new TaskApi;
        $task = $taskApi->start($stageId, $roundId)['data'] ?? [];

        $taskId = $task['id'];

        $questions = $taskApi->question($taskId)['data'] ?? abort(404);

        $roundApi = new RoundApi;

        $round = $roundApi->getDetail($roundId)['data'] ?? [];

        $timespan = $this->getTimer($roundId);

        $gameApi = new Game;

        if ($gameApi->parse($game)['uri'] === 'soalcerita') {
            return view(
                'student.exams.game._soal_cerita',
                compact('game', 'stageId', 'roundId', 'questions', 'taskId', 'timespan', 'round'),
            );
        }

        $gameApi = new Game;

        session()->forget('old_answer');

        $view = $gameApi->parse($game)['uri'] === 'soalcerita' ?
            'student.exams.game._soal_cerita' : 'student.exams.index';

        return view(
            $view,
            compact('game', 'stageId', 'roundId', 'questions', 'taskId', 'timespan', 'round'),
        );
    }

    public function checkAnswer($game, Request $request)
    {
        $taskApi = new TaskApi;

        $answer = $request->answer;

        if ($game !== 'menulisefektif' && $game !== 'soalcerita') {
            $answer = strtolower($request->answer);
        }

        if ($request->type === 'benar_salah') {
            $answers = [];
            foreach ($request->answer as $key => $a) {
                $answers[$key] = [
                    'answer' => $a['answer'] === 'true' ? true : ($a['answer'] === 'false' ? false : null),
                    'question' => $a['question'],
                ];
            }

            $answer = $answers;
        }

        if ($request->type === 'mengurutkan') {
            $answers = [];
            foreach ($request->answer as $key => $value) {
                $answers[$key] = [
                    'answer' => intval($value['answer']),
                    'question' => $value['question'],
                ];
            }

            $answer = $answers;
        }

        $task = $taskApi
                ->answer($request->task_id, $request->id, $answer ?? 'null')['data'] ?? [];
        
        $status = $task['is_correct'] ?? false;
        $answer = $task['correct_answer'] ?? '';

        if ($status === false) {
            session()->put('old_answer.' . $task['question_id'], $task['answer']);
        }

        if ($request->repeatance === 'true') {
            $taskApi
                    ->answer($request->task_id, $request->id, session()->get('old_answer')[$task['question_id']]);
        }

        if (gettype($answer) === 'array') {
            $answers = [];
            foreach ($answer as $value) {
                $answers[] = $value;
            }

            $answer = $answers;
        }

        if ($request->type === 'menceklis') {
            $answer = [];
            foreach ($task['choices'] as $key => $value) {
                if (in_array($key, $task['correct_answer'])) {
                    $answer[] = $value;
                }
            }
        }

        if ($request->type === 'rumpang') {
            $answer = [];
            foreach ($task['correct_answer'] as $key => $value) {
                if (array_key_exists($value, $task['choices'][$key]['choices'])) {
                    $answer[] = $task['choices'][$key]['choices'][$value];
                }
            }
        }

        return response()->json([
            'status' => $status,
            'answer' => $answer,
            'repeatance' => $request->repeatance === 'true',
            'explanation' => $task['explanation'] ?? '',
        ]);
    }

    public function finish($game, $stageId, $roundId, $taskId)
    {
        $game;
        $stageId;
        $roundId;
        $taskApi = new TaskApi;
        $task = $taskApi->finish($taskId)['data'] ?? [];
        
        if (count($task) < 1) {
            return redirect("/student/games/$game/stages/$stageId/rounds");
        }
        
        $roundApi = new RoundApi;
        $filter = [
            'filter[stage_id]' => $stageId,
        ];
    
        $rounds = $roundApi->index($filter);
        $roundCurrent = $roundApi->getDetail($roundId)['data'];

        $roundsContainer = [];
    
        foreach ($rounds['data'] as $round) {
            if ($round['id'] !== $roundId &&
                $round['order'] > $roundCurrent['order'] &&
                $round['status'] === 'PUBLISHED') {
                $roundsContainer[] = $round;
            }
        }
        
        $nextRound = $roundsContainer[0] ?? [];

        session()->forget('old_answer');

        session()->flash('result', [
            'task' => $task,
            'nextRound' => $nextRound,
            'stageId' => $stageId,
            'roundId' => $roundId,
            'game' => $game,
        ]);

        return redirect("/student/games/$game/stages/$stageId/rounds/$roundId/$taskId/result");
    }

    public function result($game, $stageId)
    {
        try {
            $result = session()->get('result');
            $task = $result['task'];
            $nextRound = $result['nextRound'];
            $stageId = $result['stageId'];
            $roundId = $result['roundId'];
            $game = $result['game'];

            $roundApi = new RoundApi;

            $round = $roundApi->getDetail($roundId)['data'] ?? [];
    
            $gameApi = new Game;

            $gameData = $gameApi->parse($game);

            return view(
                'student.results.index',
                compact('task', 'nextRound', 'stageId', 'roundId', 'game', 'round', 'gameData'),
            );
        } catch (Throwable $th) {
            return redirect("/student/games/$game/stages/$stageId/rounds");
        }
    }

    private function getTimer($roundId)
    {
        $roundApi = new RoundApi;
        $round = $roundApi->getDetail($roundId)['data'];

        return $round['question_timespan'];
    }
}
