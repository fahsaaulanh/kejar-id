<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Game;
use App\Services\Question;
use App\Services\Round;
use App\Services\RoundQuestion;
use App\Services\Stage;
use Illuminate\Http\Request;
use Throwable;

class LiterasiController extends Controller
{
    public function index($game, $packageId, $unitId, Request $request)
    {
        $gameApi = new Game;
        $unitApi = new Round;
        $packageApi = new Stage;
        $literasiApi = new RoundQuestion;
        $questionApi = new Question;

        $game = $gameApi->parse($game);
        $packageId;
        $unitId;

        $package = $packageApi->getDetail(strtoupper($game['uri']), $packageId)['data'] ?? [];

        $unit = $unitApi->getDetail($unitId)['data'] ?? [];

        $literasiResponse = $literasiApi->getAll($unitId, $request->page ?? 1);

        $questionIds = $literasiResponse['data'] ?? [];
        $pagination = $literasiResponse['meta'] ?? [];

        $questions = [];
        foreach ($questionIds as $questionId) {
            $questions[] = $questionApi->getDetail($questionId['question_id'])['data'] ?? [];
        }

        return view('admin.questions.list._literasi', compact('questions', 'pagination', 'game', 'unit', 'package'));
    }

    public function store($game, $packageId, $unitId, Request $request)
    {
        $game;
        $packageId;
        $unitId;

        $unitQuestionApi = new RoundQuestion;
        $questionApi = new Question;
        $gameApi = new Game;

        try {
            $game = $gameApi->parse($game);
            $questionType = is_null($request->question_type) ? false : $request->question_type;

            // Pilihan Ganda
            if ($questionType === 'MCQSA') {
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
                    return redirect()->back()->width('message', 'Ada kesalahan, silahkan periksa kembali!');
                }
            }

            // End Pilihan Ganda

            // Menceklis Daftar
            if ($questionType === 'CQ') {
                $choices = [];
                $answers = [];
                $alphabet = 'A';
                foreach ($request['choices'] as $key => $choice) {
                    if (!is_null($choice)) {
                        $choices[$alphabet] = $choice;
                        if (in_array($key, $request['answer'])) {
                            $answers[] = $alphabet;
                        }

                        $alphabet++;
                    }
                }

                if (count($choices) <= 0 || count($answers) <= 0 || is_null($request['question'])) {
                    return redirect()->back()->with('message', 'Terjadi kesalahan, silahkan ulangi kembali!');
                }

                $answer = $answers;
            }

            // End Menceklis Daftar

            // Benar Salah
            if ($questionType === 'TFQMA') {
                $choices = [];

                foreach ($request->pertanyaan as $key => $value) {
                    if ($value !== null || $request->status_pertanyaan[$key] !== null) {
                        $choices[$key + 1] = [
                            'question' => $value,
                            'answer' => $request->status_pertanyaan[$key] === 'Benar',
                        ];
                    }
                }

                $answer = $choices;

                $request['question'] = $request->keterangan_soal;
                $request['explanation'] = $request->pembahasan;
            }

            // End Benar Salah

            // Ya Tidak
            if ($questionType === 'YNQMA') {
                $choices = [];
                foreach ($request->question as $key => $value) {
                    if ($value !== null || $request->answer[$key] !== null) {
                        $choices[$key + 1] = [
                            'question' => $value,
                            'answer' => strtolower($request->answer[$key]) === 'ya' ? 'yes' : 'no',
                        ];
                    }
                }

                $answer = $choices;
                $request['explanation'] = $request->pembahasan;
                $request['question'] = $request->keterangan_soal;
            }

            // End Ya Tidak

            // Mengurutkan
            if ($questionType === 'SSQ') {
                $choices = [];
                foreach ($request->answer as $key => $value) {
                    if ($value['key'] !== null && $value['description'] !== null) {
                        $choices[(String)($key + 1)] = [
                            'question' => $value['description'],
                            'answer' => (int)$value['key'],
                        ];
                    }
                }

                $request['explanation'] = $request->question['description'];
                $request['question'] = $request->question['question'];
                $answer = $choices;
            }

            // End Mengurutkan

            // Memasangkan
            if ($questionType === 'MQ') {
                $choices = [];
                $answers = [];
                $alphabet = 'A';
                foreach ($request['answer']['statement'] as $key => $statement) {
                    if (!is_null($statement) && !is_null($request['answer']['setstatement'][$key])) {
                        $choices[0][$alphabet] = $statement;
                        $alphabet++;
                    }
                }

                foreach ($request['answer']['setstatement'] as $key => $statement) {
                    if (!is_null($statement) && !is_null($request['answer']['statement'][$key])) {
                        $choices[1][$alphabet] = $statement;
                        $answers[] = $alphabet;
                        $alphabet++;
                    }
                }

                $alphabet = 'A';
                foreach ($answers as $key => $answer) {
                    $answers[$alphabet] = $answer;
                    unset($answers[$key]);
                    $alphabet++;
                }

                if (count($choices[0]) <= 0 || count($answers) <= 0) {
                    return redirect()->back()->with('message', 'Terjadi kesalahan, silahkan ulangi kembali!');
                }

                $answer = $answers;
            }

            // End Memasangkan

            // Merinci
            if ($questionType === 'BDCQMA') {
                $answers = [];
                foreach ($request['answer'] as $answer) {
                    if (!is_null($answer)) {
                        $answers[] = $answer;
                    }
                }

                if (count($answers) <= 0) {
                    return redirect()->back()->with('message', 'Terjadi kesalahan, silahkan ulangi kembali!');
                }

                $choices = $answers;
                $answer = $answers;
            }

            // End Merinci

            // Esai
            if ($questionType === 'EQ') {
                if (is_null($request['question']) || is_null($request['answer'])) {
                    return redirect()->back()->with('message', 'Terjadi kesalahan, silahkan ulangi kembali!');
                }

                $choices = null;
                $answer = $request->answer;
            }

            // End Esai

            // Isian Bahasa
            if ($questionType === 'QSAT') {
                $answers = [];
                foreach ($request['answer'] as $answer) {
                    if (!is_null($answer)) {
                        $answers[] = $answer;
                    }
                }

                if (count($answers) <= 0 || is_null($request['question'])) {
                    return redirect()->back()->with('message', 'Terjadi kesalahan, silahkan ulangi kembali!');
                }

                $choices = null;
                $answer = $answers;
            }

            // End Isian Bahasa

            // Isian Matematika
            if ($questionType === 'MQIA') {
                $choices = [];
                $choices['first'] = [];
                $choices['last'] = [];
                $answer = [];

                for ($i=0; $i < count($request->first); $i++) {
                    if (!($request->first[$i] === null &&
                        $request->last[$i] === null &&
                        $request->answer[$i] === null)) {
                            $choices['first'][] = $request->first[$i];
                            $choices['last'][] = $request->last[$i];
                            $answer[] = $request->answer[$i];
                    }
                }

                $request['question'] = $request->keterangan_soal;
                $request['explanation'] = $request->pembahasan;
            }

            // End Isian Matematika

            // Melengkapi Tabel
            if ($questionType === 'CTQ') {
                $body = [];
                foreach ($request->column['status'] as $key => $value) {
                    foreach ($value as $k => $val) {
                        $body[$key][] = [
                            'type' => $val === 'Jawaban' ? 'answer' : 'question',
                            'value' => $val === 'Jawaban' ?
                                strtolower($request->column['content'][$key][$k]) :
                                $request->column['content'][$key][$k],
                        ];
                    }
                }

                $header = $request->header;

                $choices = [
                    'header' => $header,
                    'body' => $body,
                ];

                $request['question'] = $request->keterangan_soal;
                $request['explanation'] = $request->pembahasan;
                $answer = $body;
            }

            // End Melengkapi Tabel

            // Teks Rumpang PG
            if ($questionType === 'IQ') {
                $choices = [];
                $answers = [];
                $num = 0;
                foreach ($request['choices'] as $key1 => $data) {
                    $alphabet = 'A';
                    if ($key1 === 0) {
                        $choices[$num]['question'] = $request['question'];
                        foreach ($data['description'] as $key2 => $choice) {
                            if (!isset($data['answer'])) {
                                return redirect()->back()->with(
                                    'message',
                                    'Jawaban belum dipilih. Gagal Menambahkan Data!',
                                );
                            }

                            if (intval($data['answer']) === $key2) {
                                $answers[] = $alphabet;
                            }

                            if ($choice) {
                                $choices[$num]['choices'][$alphabet] = $choice;
                            }

                            $alphabet++;
                        }

                        $choices[$num]['choices'] = $choices[$num]['choices'];
                        $choices[$num] = $choices[$num];
                        $num++;
                    } else {
                        if (!is_array($data)) {
                            $choices[$num]['question'] = $data;
                            $choices[$num]['choices'] = null;
                        } else {
                            foreach ($data['description'] as $key2 => $choice) {
                                if (intval($data['answer']) === $key2) {
                                    $answers[] = $alphabet;
                                }

                                if ($choice) {
                                    $choices[$num]['choices'][$alphabet] = $choice;
                                }

                                $alphabet++;
                            }

                            $num++;
                        }
                    }
                }

                foreach ($choices as $key => $choice) {
                    $choices[$key]['choices'] = (object)$choice['choices'];
                }

                $answer = $answers;
            }

            // End Teks Rumpang PG

            $collection = [
                'subject_id' => null,
                'topic_id' => null,
                'bank' => $game['short'],
                'question' => $request['question'],
                'level' => 'LEVEL_1',
                'created_by' => session('user.id'),
                'type' => $questionType,
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

            $roundQuestionMeta = $unitQuestionApi->getAll($unitId, $request->page ?? 1)['meta'] ?? [];
            $questionTotal = $roundQuestionMeta['total'] ?? 0;

            $payloadQS = [
                'question_id' => $question['data']['id'],
                'round_id' => $unitId,
                'order' => $questionTotal + 1,
            ];

            $unitQuestionApi->store($question['data']['id'], $payloadQS);

            return redirect()->back()->with('message', 'Berhasil menambahkan soal!');
        } catch (Throwable $th) {
            return redirect()->back()->with('message', 'Maaf terjadi kesalahan, silahkan ulangi kembali!');
        }
    }

    public function show($game, $packageId, $unitId, $questionId)
    {
        $game;
        $packageId;
        $unitId;

        $questionApi = new Question;
        $question = $questionApi->getDetail($questionId)['data'] ?? [];

        return response()->json($question);
    }

    public function update($game, $packageId, $unitId, $questionId, Request $request)
    {
        $game;
        $packageId;
        $unitId;
        $questionId;

        $questionApi = new Question;
        $gameApi = new Game;

        try {
            $game = $gameApi->parse($game);
            $questionType = is_null($request->question_type) ? false : $request->question_type;

            // Pilihan Ganda
            if ($questionType === 'MCQSA') {
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
                    return redirect()->back()->width('message', 'Ada kesalahan, silahkan periksa kembali!');
                }
            }

            // End Pilihan Ganda

            // Menceklis Daftar
            if ($questionType === 'CQ') {
                $choices = [];
                $answers = [];
                $alphabet = 'A';
                foreach ($request['choices'] as $key => $choice) {
                    if (!is_null($choice)) {
                        $choices[$alphabet] = $choice;
                        if (in_array($key, $request['answer'])) {
                            $answers[] = $alphabet;
                        }

                        $alphabet++;
                    }
                }

                if (count($choices) <= 0 || count($answers) <= 0 || is_null($request['question'])) {
                    return redirect()->back()->with('message', 'Terjadi kesalahan, silahkan ulangi kembali!');
                }

                $answer = $answers;
            }

            // End Menceklis Daftar

            // Benar Salah
            if ($questionType === 'TFQMA') {
                $choices = [];

                foreach ($request->pertanyaan as $key => $value) {
                    if ($value !== null || $request->status_pertanyaan[$key] !== null) {
                        $choices[$key + 1] = [
                            'question' => $value,
                            'answer' => $request->status_pertanyaan[$key] === 'Benar',
                        ];
                    }
                }

                $answer = $choices;

                $request['question'] = $request->keterangan_soal;
                $request['explanation'] = $request->pembahasan;
            }

            // End Benar Salah

            // Ya Tidak
            if ($questionType === 'YNQMA') {
                $choices = [];
                foreach ($request->question as $key => $value) {
                    if ($value !== null || $request->answer[$key] !== null) {
                        $choices[$key + 1] = [
                            'question' => $value,
                            'answer' => strtolower($request->answer[$key]) === 'ya' ? 'yes' : 'no',
                        ];
                    }
                }

                $answer = $choices;
                $request['explanation'] = $request->pembahasan;
                $request['question'] = $request->keterangan_soal;
            }

            // End Ya Tidak

            // Mengurutkan
            if ($questionType === 'SSQ') {
                $choices = [];
                foreach ($request->answer as $key => $value) {
                    if ($value['key'] !== null && $value['description'] !== null) {
                        $choices[(String)($key + 1)] = [
                            'question' => $value['description'],
                            'answer' => (int)$value['key'],
                        ];
                    }
                }

                $request['explanation'] = $request->question['description'];
                $request['question'] = $request->question['question'];
                $answer = $choices;
            }

            // End Mengurutkan

            // Memasangkan
            if ($questionType === 'MQ') {
                $choices = [];
                $answers = [];
                $alphabet = 'A';
                foreach ($request['answer']['statement'] as $key => $statement) {
                    if (!is_null($statement) && !is_null($request['answer']['setstatement'][$key])) {
                        $choices[0][$alphabet] = $statement;
                        $alphabet++;
                    }
                }

                foreach ($request['answer']['setstatement'] as $key => $statement) {
                    if (!is_null($statement) && !is_null($request['answer']['statement'][$key])) {
                        $choices[1][$alphabet] = $statement;
                        $answers[] = $alphabet;
                        $alphabet++;
                    }
                }

                $alphabet = 'A';
                foreach ($answers as $key => $answer) {
                    $answers[$alphabet] = $answer;
                    unset($answers[$key]);
                    $alphabet++;
                }

                if (count($choices[0]) <= 0 || count($answers) <= 0) {
                    return redirect()->back()->with('message', 'Terjadi kesalahan, silahkan ulangi kembali!');
                }

                $answer = $answers;
            }

            // End Memasangkan

            // Merinci
            if ($questionType === 'BDCQMA') {
                $answers = [];
                foreach ($request['answer'] as $answer) {
                    if (!is_null($answer)) {
                        $answers[] = $answer;
                    }
                }

                if (count($answers) <= 0) {
                    return redirect()->back()->with('message', 'Terjadi kesalahan, silahkan ulangi kembali!');
                }

                $choices = $answers;
                $answer = $answers;
            }

            // End Merinci

            // Esai
            if ($questionType === 'EQ') {
                if (is_null($request['question']) || is_null($request['answer'])) {
                    return redirect()->back()->with('message', 'Terjadi kesalahan, silahkan ulangi kembali!');
                }

                $choices = null;
                $answer = $request->answer;
            }

            // End Esai

            // Isian Bahasa
            if ($questionType === 'QSAT') {
                $answers = [];
                foreach ($request['answer'] as $answer) {
                    if (!is_null($answer)) {
                        $answers[] = $answer;
                    }
                }

                if (count($answers) <= 0 || is_null($request['question'])) {
                    return redirect()->back()->with('message', 'Terjadi kesalahan, silahkan ulangi kembali!');
                }

                $choices = null;
                $answer = $answers;
            }

            // End Isian Bahasa

            // Isian Matematika
            if ($questionType === 'MQIA') {
                $choices = [];
                $choices['first'] = [];
                $choices['last'] = [];
                $answer = [];

                for ($i=0; $i < count($request->first); $i++) {
                    if (!($request->first[$i] === null &&
                        $request->last[$i] === null &&
                        $request->answer[$i] === null)) {
                            $choices['first'][] = $request->first[$i];
                            $choices['last'][] = $request->last[$i];
                            $answer[] = $request->answer[$i];
                    }
                }

                $request['question'] = $request->keterangan_soal;
                $request['explanation'] = $request->pembahasan;
            }

            // End Isian Matematika

            // Melengkapi Tabel
            if ($questionType === 'CTQ') {
                $body = [];
                foreach ($request->column['status'] as $key => $value) {
                    foreach ($value as $k => $val) {
                        $body[$key][] = [
                            'type' => $val === 'Jawaban' ? 'answer' : 'question',
                            'value' => $val === 'Jawaban' ?
                                strtolower($request->column['content'][$key][$k]) :
                                $request->column['content'][$key][$k],
                        ];
                    }
                }

                $header = $request->header;

                $choices = [
                    'header' => $header,
                    'body' => $body,
                ];

                $request['question'] = $request->keterangan_soal;
                $request['explanation'] = $request->pembahasan;
                $answer = $body;
            }

            // End Melengkapi Tabel

            // Teks Rumpang PG
            if ($questionType === 'IQ') {
                $choices = [];
                $answers = [];
                $num = 0;
                foreach ($request['choices'] as $key1 => $data) {
                    $alphabet = 'A';
                    if ($key1 === 0) {
                        $choices[$num]['question'] = $request['question'];
                        foreach ($data['description'] as $key2 => $choice) {
                            if (!isset($data['answer'])) {
                                return redirect()->back()->with(
                                    'message',
                                    'Jawaban belum dipilih. Gagal mengubah Data!',
                                );
                            }

                            if (intval($data['answer']) === $key2) {
                                $answers[] = $alphabet;
                            }

                            if ($choice) {
                                $choices[$num]['choices'][$alphabet] = $choice;
                            }

                            $alphabet++;
                        }

                        $choices[$num]['choices'] = $choices[$num]['choices'];
                        $choices[$num] = $choices[$num];
                        $num++;
                    } else {
                        if (!is_array($data)) {
                            $choices[$num]['question'] = $data;
                            $choices[$num]['choices'] = null;
                        } else {
                            foreach ($data['description'] as $key2 => $choice) {
                                if (intval($data['answer']) === $key2) {
                                    $answers[] = $alphabet;
                                }

                                if ($choice) {
                                    $choices[$num]['choices'][$alphabet] = $choice;
                                }

                                $alphabet++;
                            }

                            $num++;
                        }
                    }
                }

                foreach ($choices as $key => $choice) {
                    $choices[$key]['choices'] = (object)$choice['choices'];
                }

                $answer = $answers;
            }

            // End Teks Rumpang PG

            $collection = [
                'question'=> $request['question'],
                'choices' => $choices,
                'answer'=> $answer,
                'tags' => ['answer', 'question'],
                'created_by' => session('user.id'),
                'type' => $questionType,
            ];

            $question = $questionApi->update($questionId, $collection);

            if ($question['error']) {
                return redirect()->back()->with('message', 'Maaf terjadi kesalahan, silahkan ulangi kembali!');
            }

            $updateData = [
                'explanation' => (string)$request['explanation'],
                'explained_by' => session('user.id'),
                'tags' => ['explanation'],
                'note' => 'explanation',
            ];

            $questionApi->update($questionId, $updateData);

            return redirect()->back()->with('message', 'Berhasil mengubah soal!');
        } catch (Throwable $th) {
            return redirect()->back()->with('message', 'Maaf terjadi kesalahan, silahkan ulangi kembali!');
        }
    }
}
