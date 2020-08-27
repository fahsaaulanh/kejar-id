<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
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

        return view(
            'student.exams.index',
            compact('game', 'stageId', 'roundId', 'questions', 'taskId', 'timespan', 'round'),
        );
    }

    public function checkAnswer($game, Request $request)
    {
        $taskApi = new TaskApi;

        $answer = $request->answer;

        if ($game !== 'menulisefektif') {
            $answer = strtolower($request->answer);
        }

        $task = $taskApi
                ->answer($request->task_id, $request->id, $answer ?? 'null')['data'] ?? [];
        
        $status = $task['is_correct'] ?? false;
        $answer = $task['correct_answer'] ?? '';
        if ($request->repeatance === 'true') {
            $taskApi->answer($request->task_id, $request->id, 'null')['data'] ?? [];
        }

        return response()->json([
            'status' => $status,
            'answer' => $answer,
            'repeatance' => $request->repeatance === 'true',
            'explanation' => $task['explanation'],
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
    
            return view('student.results.index', compact('task', 'nextRound', 'stageId', 'roundId', 'game'));
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
