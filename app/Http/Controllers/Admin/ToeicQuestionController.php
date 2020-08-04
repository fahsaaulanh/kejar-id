<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Game;
use App\Services\Question as QuestionApi;
use App\Services\Round as RoundApi;
use App\Services\RoundQuestion;
use App\Services\Stage as StageApi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class ToeicQuestionController extends Controller
{

    public function index($game, $stageId, $roundId, Request $request)
    {
        $roundApi = new RoundApi;
        $round = $roundApi->getDetail($roundId)['data'] ?? null;
        if ($round === null) {
            abort('404');
        }

        $stageApi = new StageApi;
        $stage = $stageApi->getDetail($game, $stageId)['data'] ?? [];
        if (count($stage) < 1 || $stage['game'] !== $game) {
            abort('404');
        }

        $roundQuestionApi = new RoundQuestion;
        $roundQuestions = $roundQuestionApi->getAll($roundId, $request->page ?? 1);
        $roundQuestionsData = $roundQuestions['data'] ?? [];
        $roundQuestionsMeta = $roundQuestions['meta'] ?? [];

        $questionApi = new QuestionApi;

        for ($i=0; $i < count($roundQuestionsData); $i++) {
            $question = $questionApi->getDetail($roundQuestionsData[$i]['question_id']);
            if (!($question['data'] ?? null)) {
                continue;
            }

            $roundQuestionsData[$i]['question'] = $question['data'];
        }

        $gameService = new Game;
        $game = $gameService->parse($game);

        return view(
            'admin.questions.toeic.index',
            compact('game', 'stage', 'round', 'roundQuestionsData', 'roundQuestionsMeta'),
        );
    }

    public function upload($game, $stageId, $roundId, Request $request)
    {
        $game;
        $stageId;
        $roundId;

        $this->validate($request, [
            'question_file' => 'required|file',
        ]);

        $file = $request->file('question_file');

        try {
            $data = Excel::toArray([], $file);

            if ($data[0][3][0] !== 'ID Ronde') {
                return redirect()->back()->withErrors([
                    'error' => ['Data tidak berhasil diunggah! Silakan download format data yang tersedia!'],
                ]);
            }

            $questionApi = new QuestionApi;
            $roundQuestionApi = new RoundQuestion;
            $gameService = new Game;
            $gameParsed = $gameService->parse($game);

            for ($i=4; $i < count($data[0]); $i++) {
                $sheetIndex = 0;
                $row = $i;
                $roundIdIndex = 0;
                $questionIndex = 1;
                $answerIndex = 2;
                // $game = $data[$sheetIndex][0][1];

                $collection = [
                    'owner' => 'KEJAR',
                    'subject_id'=> null,
                    'topic_id'=> null,
                    'bank'=> $gameParsed['short'],
                    'type'=> 'MCQSA',
                    'question'=> (string)$data[$sheetIndex][$row][$questionIndex],
                    'choices'=> null,
                    'answer'=> (string)$data[$sheetIndex][$row][$answerIndex],
                    'level'=> 'LEVEL_1',
                    'status' => '1',
                    'created_by'=> session('user.id'),
                ];

                $question = $questionApi->store($collection);

                // update status to Valid
                $questionApi->update($question['data']['id'], ['status' => '2']);

                $roundQuestionMeta = $roundQuestionApi
                                ->getAll($data[$sheetIndex][$row][$roundIdIndex], $request->page ?? 1)['meta'] ?? [];
                $questionTotal = $roundQuestionMeta['total'] ?? 0;

                $payloadQS = [
                    'question_id' => $question['data']['id'],
                    'round_id' => $data[$sheetIndex][$row][$roundIdIndex],
                    'order' => $questionTotal + 1,
                ];

                $roundQuestionApi->store($question['data']['id'], $payloadQS);
            }
        } catch (Throwable $th) {
            return $th;
        }

        return redirect()->back()->with('message', 'Soal berhasil ditambahkan!');
    }

    public function create($game, $stageId, $roundId, Request $request)
    {
        $game;
        $stageId;
        $roundId;

        try {
            $questionApi = new QuestionApi;
            $roundQuestionApi = new RoundQuestion;
            $gameService = new Game;
            $gameParsed = $gameService->parse($game);

            foreach ($request->input('question') as $question) {
                if ($question['question'] !== null && $question['answer'] !== null) {
                    $collection = [
                        'owner' => 'KEJAR',
                        'subject_id'=> null,
                        'topic_id'=> null,
                        'bank'=> $gameParsed['short'],
                        'type'=> 'MCQSA',
                        'question'=> (string)$question['question'],
                        'choices'=> null,
                        'answer'=> (string)$question['answer'],
                        'level'=> 'LEVEL_1',
                        'status' => '2',
                        'created_by'=> session('user.id'),
                    ];

                    $question = $questionApi->store($collection);
                    // update status to Valid
                    $questionApi->update($question['data']['id'], ['status' => '2']);

                    $roundQuestionMeta = $roundQuestionApi->getAll($roundId, $request->page ?? 1)['meta'] ?? [];
                    $questionTotal = $roundQuestionMeta['total'] ?? 0;

                    $payloadQS = [
                        'question_id' => $question['data']['id'],
                        'round_id' => $roundId,
                        'order' => $questionTotal + 1,
                    ];

                    $roundQuestionApi->store($question['data']['id'], $payloadQS);
                }
            }
        } catch (Throwable $th) {
            return $th;
        }

        return redirect()->back()->with('message', 'Berhasil menambahkan data!');
    }

    public function update($game, $stageId, $roundId, Request $request)
    {
        $game;
        $stageId;
        $roundId;
        try {
            $roundApi = new RoundApi;

            $round = $roundApi->getDetail($roundId)['data'] ?? [];

            $payload = [
                'title' => $request->title ?? $round['title'],
                'description' => $request->description ?? $round['description'],
                'direction' => $request->direction ?? $round['direction'],
                'material' => $request->material ?? $round['material'],
                'total_question' => $request->total_question ?? $round['total_question'],
                'question_timespan' => $request->question_timespan ?? $round['question_timespan'],
                'status' => $request->status ?? $round['status'],
            ];

            $roundApi->update($payload, $round['id']);
        } catch (Throwable $th) {
            return $th;
        }

        return redirect()->back()->with('message', 'Mengubah Data Ronde Berhasil!');
    }

    public function updateQuestion($game, $stageId, $roundId, $questionId, Request $request)
    {
        $game;
        $stageId;
        $roundId;
        $questionId;

        $this->validate($request, [
            'question' => 'required',
            'answer' => 'required',
        ]);

        try {
            $questionApi = new QuestionApi;


            $payload = [
                'question'=> (string)$request->question,
                'answer'=> (string)$request->answer,
                'tags' => ['answer', 'question'],
                'created_by' => session('user.id'),
            ];

            $questionApi->update($questionId, $payload);
        } catch (Throwable $th) {
            return $th;
        }

        return redirect()->back()->with('message', 'Berhasil mengubah soal!');
    }
}
