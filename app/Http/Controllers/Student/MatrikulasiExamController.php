<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\Round as RoundApi;
use App\Services\Task as TaskApi;
use Illuminate\Http\Request;

class MatrikulasiExamController extends Controller
{

    public function index($game, $stageId, $roundId)
    {

        $taskApi = new TaskApi;
        $task = $taskApi->start($stageId, $roundId)['data'];

        $taskId = $task['id'];

        $questions = $taskApi->question($taskId)['data'] ?? abort(404);

        $timespan = $this->getTimer($roundId);

        return view('student.exams.index', compact('game', 'stageId', 'roundId', 'questions', 'taskId', 'timespan'));
    }

    public function checkAnswer(Request $request)
    {
        $taskApi = new TaskApi;

        $task = $taskApi->answer($request->task_id, $request->id, $request->answer ?? 'empty')['data'] ?? [];
        $status = $task['is_correct'] ?? false;
        $answer = $task['correct_answer'] ?? '';
        if ($request->repeatance === 'true') {
            $taskApi->answer($request->task_id, $request->id, 'empty')['data'] ?? [];
        }

        return response()->json([
            'status' => $status,
            'answer' => $answer,
            'repeatance' => $request->repeatance === 'true',
        ]);
    }

    public function finish($game, $stageId, $roundId, $taskId)
    {
        $game;
        $stageId;
        $roundId;
        $taskApi = new TaskApi;
        $task = $taskApi->finish($taskId)['data'];

        return view('student.results.index', compact('task'));
    }

    private function getTimer($roundId)
    {
        $roundApi = new RoundApi;
        $round = $roundApi->getDetail($roundId)['data'];

        return $round['question_timespan'];
    }
}
