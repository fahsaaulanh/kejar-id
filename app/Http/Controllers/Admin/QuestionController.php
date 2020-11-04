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

class QuestionController extends Controller
{

    public function index($game, $stageId, $roundId, Request $request)
    {
        $game = strtoupper($game);
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

        $view = 'admin.questions.index';
        if ($game['uri'] === 'toeicwords') {
            $view = 'admin.questions.list._toeic_words';
        } elseif ($game['uri'] === 'soalcerita') {
            $view = 'admin.questions.soalcerita.index';
        } elseif ($game['uri'] === 'menulisefektif') {
            $view = 'admin.questions.list._menulis_efektif';
        }

        return view(
            $view,
            compact('game', 'stage', 'round', 'roundQuestionsData', 'roundQuestionsMeta'),
        );
    }

    public function upload($game, $stageId, $roundId, Request $request)
    {
        $game = strtoupper($game);
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
                    'question'=> (string)strtolower($data[$sheetIndex][$row][$questionIndex]),
                    'choices'=> null,
                    'answer'=> (string)strtolower($data[$sheetIndex][$row][$answerIndex]),
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
        $game = strtoupper($game);
        $stageId;
        $roundId;

        try {
            $questionApi = new QuestionApi;
            $roundQuestionApi = new RoundQuestion;
            $gameService = new Game;
            $gameParsed = $gameService->parse($game);
            $questionType = is_null($request->question_type) ? false : $request->question_type;
            if ($game === 'MENULISEFEKTIF') {
                $answers = [];
                foreach ($request['question.answer'] as $answer) {
                    if (!is_null($answer)) {
                        $answers[] = $answer;
                    }
                }

                if (!is_null($request['question.question']) && count($answers) !== 0) {
                    $collection = [
                        'owner' => 'KEJAR',
                        'subject_id'=> null,
                        'topic_id'=> null,
                        'bank'=> $gameParsed['short'],
                        'type'=> 'QSAT',
                        'question'=> $request['question.question'],
                        'choices'=> null,
                        'answer'=> $answers,
                        'level'=> 'LEVEL_1',
                        'created_by' => session('user.id'),
                    ];

                    $question = $questionApi->store($collection);

                    $updateData = [
                        'explanation' => (string)$request['question.explanation'],
                        'explained_by' => session('user.id'),
                        'tags' => ['explanation'],
                        'note' => 'explanation',
                    ];

                    $questionApi->update($question['data']['id'], $updateData);
                    $questionApi->update($question['data']['id'], ['status' => 2]);
                    $roundQuestionMeta = $roundQuestionApi->getAll($roundId, $request->page ?? 1)['meta'] ?? [];
                    $questionTotal = $roundQuestionMeta['total'] ?? 0;

                    $payloadQS = [
                        'question_id' => $question['data']['id'],
                        'round_id' => $roundId,
                        'order' => $questionTotal + 1,
                    ];

                    $roundQuestionApi->store($question['data']['id'], $payloadQS);
                }
            } else {
                if ($questionType === false) {
                    foreach ($request->input('question') as $question) {
                        if ($question['question'] !== null && $question['answer'] !== null) {
                            $collection = [
                                'owner' => 'KEJAR',
                                'subject_id'=> null,
                                'topic_id'=> null,
                                'bank'=> $gameParsed['short'],
                                'type'=> 'QSAT',
                                'question'=> (string)strtolower($question['question']),
                                'choices'=> null,
                                'answer'=> (string)strtolower($question['answer']),
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
                } elseif ($questionType === 'MCQSA') {
                    $choices = [];
                    $alphabet = 'A';
                    foreach ($request['choices'] as $key => $choice) {
                        if (!is_null($choice)) {
                            $choices[$alphabet] = $choice;
                            if ($key === intval($request['answer'])) {
                                $answer = $alphabet;
                            }

                            $alphabet++;
                        }
                    }

                    if (count($choices) <= 0 || is_null($request['question']) || is_null($request['answer'])) {
                        return redirect()->back();
                    }

                    $collection = [
                        'subject_id' => null,
                        'topic_id' => null,
                        'bank' => $gameParsed['short'],
                        'question' => $request['question'],
                        'level' => 'LEVEL_1',
                        'created_by' => session('user.id'),
                        'type' => 'MCQSA',
                        'choices' => $choices,
                        'answer' => $answer,
                    ];

                    $question = $questionApi->store($collection);

                    $updateData = [
                        'explanation' => (string)$request['explanation'],
                        'explained_by' => session('user.id'),
                        'tags' => ['explanation'],
                        'note' => 'explanation',
                    ];

                    $questionApi->update($question['data']['id'], ['status' => '2']);
                    $questionApi->update($question['data']['id'], $updateData);

                    $roundQuestionMeta = $roundQuestionApi->getAll($roundId, $request->page ?? 1)['meta'] ?? [];
                    $questionTotal = $roundQuestionMeta['total'] ?? 0;

                    $payloadQS = [
                        'question_id' => $question['data']['id'],
                        'round_id' => $roundId,
                        'order' => $questionTotal + 1,
                    ];

                    $roundQuestionApi->store($question['data']['id'], $payloadQS);
                } elseif ($questionType === 'TFQMA') {
                    $choices = [];

                    foreach ($request->pertanyaan as $key => $value) {
                        if ($value !== null || $request->status_pertanyaan[$key] !== null) {
                            $choices[$key + 1] = [
                                'question' => $value,
                                'answer' => $request->status_pertanyaan[$key] === 'Benar',
                            ];
                        }
                    }

                    if (count($choices) > 0) {
                        $collection = [
                            'subject_id' => null,
                            'topic_id' => null,
                            'bank' => $gameParsed['short'],
                            'question' => $request->keterangan_soal,
                            'level' => 'LEVEL_1',
                            'created_by' => session('user.id'),
                            'type' => 'TFQMA',
                            'choices' => $choices,
                            'answer' => $choices,
                        ];

                        $question = $questionApi->store($collection);

                        $updateData = [
                            'explanation' => (string)$request->pembahasan,
                            'explained_by' => session('user.id'),
                            'tags' => ['explanation'],
                            'note' => 'explanation',
                        ];

                        $questionApi->update($question['data']['id'], ['status' => '2']);
                        $questionApi->update($question['data']['id'], $updateData);

                        $roundQuestionMeta = $roundQuestionApi->getAll($roundId, $request->page ?? 1)['meta'] ?? [];
                        $questionTotal = $roundQuestionMeta['total'] ?? 0;

                        $payloadQS = [
                            'question_id' => $question['data']['id'],
                            'round_id' => $roundId,
                            'order' => $questionTotal + 1,
                        ];

                        $roundQuestionApi->store($question['data']['id'], $payloadQS);
                    }
                } elseif ($questionType === 'SSQ') {
                    $choices = [];
                    foreach ($request->answer as $key => $value) {
                        if ($value['key'] !== null && $value['description'] !== null) {
                            $choices[(String)($key + 1)] = [
                                'question' => $value['description'],
                                'answer' => (int)$value['key'],
                            ];
                        }
                    }

                    if (count($choices) > 0) {
                        $collection = [
                            'subject_id' => null,
                            'topic_id' => null,
                            'bank' => $gameParsed['short'],
                            'question' => $request->question['question'],
                            'level' => 'LEVEL_1',
                            'created_by' => session('user.id'),
                            'type' => 'SSQ',
                            'choices' => $choices,
                            'answer' => $choices,
                        ];

                        $question = $questionApi->store($collection);

                        $updateData = [
                            'explanation' => (string)$request->question['description'],
                            'explained_by' => session('user.id'),
                            'tags' => ['explanation'],
                            'note' => 'explanation',
                        ];

                        $questionApi->update($question['data']['id'], ['status' => '2']);
                        $questionApi->update($question['data']['id'], $updateData);

                        $roundQuestionMeta = $roundQuestionApi->getAll($roundId, $request->page ?? 1)['meta'] ?? [];
                        $questionTotal = $roundQuestionMeta['total'] ?? 0;

                        $payloadQS = [
                            'question_id' => $question['data']['id'],
                            'round_id' => $roundId,
                            'order' => $questionTotal + 1,
                        ];

                        $roundQuestionApi->store($question['data']['id'], $payloadQS);
                    }
                } elseif ($questionType === 'CQ') {
                    $choices = [];
                    $answers = [];
                    $alphabet = 'A';
                    foreach ($request['choices'] as $key => $choice) {
                        if (!is_null($choice)) {
                            $choices[$alphabet] = $choice;
                            if (in_array($key, $request['answer'], true)) {
                                $answers[] = $alphabet;
                            }

                            $alphabet++;
                        }
                    }

                    if (count($choices) <= 0 || count($answers) <= 0 || is_null($request['question'])) {
                        return redirect()->back();
                    }

                    $collection = [
                        'subject_id' => null,
                        'topic_id' => null,
                        'bank' => $gameParsed['short'],
                        'question' => $request['question'],
                        'level' => 'LEVEL_1',
                        'created_by' => session('user.id'),
                        'type' => 'CQ',
                        'choices' => $choices,
                        'answer' => $answers,
                    ];

                    $question = $questionApi->store($collection);

                    $updateData = [
                        'explanation' => (string)$request['explanation'],
                        'explained_by' => session('user.id'),
                        'tags' => ['explanation'],
                        'note' => 'explanation',
                    ];

                    $questionApi->update($question['data']['id'], ['status' => '2']);
                    $questionApi->update($question['data']['id'], $updateData);

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

    public function editQuestion($game, $stageId, $roundId, $questionId)
    {
        $game;
        $stageId;
        $roundId;

        $questionApi = new QuestionApi;
        $questionDetail = $questionApi->getDetail($questionId)['data'];

        return response()->json($questionDetail);
    }

    public function updateQuestion($game, $stageId, $roundId, $questionId, Request $request)
    {
        $game;
        $stageId;
        $roundId;
        $questionId;
        $questionType = is_null($request->question_type) ? false : $request->question_type;
        if ($game === 'menulisefektif') {
            try {
                $questionApi = new QuestionApi;

                $answers = [];
                foreach ($request['question.answer'] as $answer) {
                    if (!is_null($answer)) {
                        $answers[] = $answer;
                    }
                }

                $payload = [
                    'question'=> $request['question.question'],
                    'answer'=> $answers,
                    'tags' => ['answer', 'question'],
                    'created_by' => session('user.id'),
                ];

                $questionApi->update($questionId, $payload);

                $updateData = [
                    'explanation' => (string)$request['question.explanation'],
                    'explained_by' => session('user.id'),
                    'tags' => ['explanation'],
                    'note' => 'explanation',
                ];

                $questionApi->update($questionId, $updateData);
            } catch (Throwable $th) {
                return $th;
            }

            return redirect()->back()->with('message', 'Berhasil mengubah soal!');
        }

        if ($questionType === false) {
            $this->validate($request, [
                'question' => 'required',
                'answer' => 'required',
            ]);

            try {
                $questionApi = new QuestionApi;

                $payload = [
                    'question'=> (string)strtolower($request->question),
                    'answer'=> (string)strtolower($request->answer),
                    'tags' => ['answer', 'question'],
                    'created_by' => session('user.id'),
                ];

                $questionApi->update($questionId, $payload);
            } catch (Throwable $th) {
                return $th;
            }
        } else {
            if ($questionType === 'MCQSA') {
                $this->validate($request, [
                    'question' => 'required',
                    'answer' => 'required',
                ]);

                $questionApi = new QuestionApi;

                $choices = [];
                $alphabet = 'A';
                foreach ($request['choices'] as $key => $choice) {
                    if (!is_null($choice)) {
                        $choices[$alphabet] = $choice;
                        if ($key === intval($request['answer'])) {
                            $answer = $alphabet;
                        }

                        $alphabet++;
                    }
                }

                if (count($choices) <= 0) {
                    return redirect()->back();
                }

                $payload = [
                    'question' => $request['question'],
                    'choices' => $choices,
                    'answer' => $answer,
                    'tags' => ['answer', 'question'],
                    'created_by' => session('user.id'),
                ];

                $questionApi->update($questionId, $payload);

                $updateData = [
                    'explanation' => $request['explanation'],
                    'explained_by' => session('user.id'),
                    'tags' => ['explanation'],
                    'note' => 'explanation',
                ];

                $questionApi->update($questionId, $updateData);
            } elseif ($request->question_type === 'TFQMA') {
                $questionApi = new QuestionApi;

                $choices = [];
                foreach ($request->pertanyaan as $key => $value) {
                    if ($value !== null || $request->status_pertanyaan[$key] !== null) {
                        $choices[$key + 1] = [
                            'question' => $value,
                            'answer' => $request->status_pertanyaan[$key] === 'Benar',
                        ];
                    }
                }

                $payload = [
                    'question' => (string)($request->keterangan_soal),
                    'choices' => $choices,
                    'answer' => $choices,
                    'tags' => ['answer', 'question'],
                    'created_by' => session('user.id'),
                ];

                $questionApi->update($questionId, $payload);

                $updateData = [
                    'explanation' => (string)$request->pembahasan,
                    'explained_by' => session('user.id'),
                    'tags' => ['explanation'],
                    'note' => 'explanation',
                ];

                $questionApi->update($questionId, $updateData);
            } elseif ($request->question_type === 'SSQ') {
                $questionApi = new QuestionApi;
                $choices = [];
                foreach ($request->answer as $key => $value) {
                    if ($value['key'] !== null && $value['description'] !== null) {
                        $choices[(String)($key + 1)] = [
                            'question' => $value['description'],
                            'answer' => (int)$value['key'],
                        ];
                    }
                }

                $payload = [
                    'question' => (string)($request->question['question']),
                    'choices' => $choices,
                    'answer' => $choices,
                    'tags' => ['answer', 'question'],
                    'created_by' => session('user.id'),
                ];

                $questionApi->update($questionId, $payload);

                $updateData = [
                    'explanation' => (string)$request->question['description'],
                    'explained_by' => session('user.id'),
                    'tags' => ['explanation'],
                    'note' => 'explanation',
                ];

                $questionApi->update($questionId, $updateData);
            } elseif ($request->question_type === 'CQ') {
                $questionApi = new QuestionApi;
                $this->validate($request, [
                    'question' => 'required',
                ]);

                $choices = [];
                $answers = [];
                $alphabet = 'A';

                foreach ($request['choices'] as $key => $choice) {
                    if (!is_null($choice)) {
                        $choices[$alphabet] = $choice;
                        if (in_array($key, $request['answer'], true)) {
                            $answers[] = $alphabet;
                        }

                        $alphabet++;
                    }
                }

                if (count($choices) <= 0 || count($answers) <= 0) {
                    return redirect()->back();
                }

                $payload = [
                    'question' => $request['question'],
                    'choices' => $choices,
                    'answer' => $answers,
                    'tags' => ['answer', 'question'],
                    'created_by' => session('user.id'),
                ];

                $questionApi->update($questionId, $payload);

                $updateData = [
                    'explanation' => $request['explanation'],
                    'explained_by' => session('user.id'),
                    'tags' => ['explanation'],
                    'note' => 'explanation',
                ];

                $questionApi->update($questionId, $updateData);
            }
        }

        return redirect()->back()->with('message', 'Berhasil mengubah soal!');
    }
}
