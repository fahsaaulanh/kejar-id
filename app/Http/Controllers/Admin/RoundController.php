<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Question as QuestionApi;
use App\Services\Round as RoundApi;
use App\Services\RoundQuestion;
use App\Services\Stage as StageApi;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class RoundController extends Controller
{
    public function index($game, $stageId)
    {
        $stageApi = new StageApi;
        $response = $stageApi->getDetail($game, $stageId);
        $stage = $response['data'];

        $roundApi = new RoundApi;
        $filter = [
            'filter[stage_id]' => $stageId,
            'per_page' => 99,
        ];
        $response = $roundApi->index($filter);
        $rounds = $response['data'] ?? [];

        // For ordering the round
        if ($rounds !== '') {
            $round = [];
            foreach ($rounds as $key => $row) {
                $round[$key] = $row['order'];
            }

            array_multisort($round, SORT_ASC, $rounds);
        } else {
            $rounds = '';
        }

        if ($game === 'OBR') {
            $game = ['short' => 'OBR', 'title' => 'Operasi Bilangan Rill', 'uri' => 'OBR'];
        } elseif ($game === 'VOCABULARY') {
            $game = ['short' => 'Vocabulary', 'title' => 'VOCABULARY', 'uri' => 'VOCABULARY'];
        } elseif ($game === 'KATABAKU') {
            $game = ['short' => 'Kata Baku', 'title' => 'KATA BAKU', 'uri' => 'KATABAKU'];
        } else {
            abort(404);
        }

        return view('admin/round/index', compact('game', 'stage', 'rounds'));
    }

    public function updateStatus(Request $request, $game, $stageId, $roundId)
    {
        $game ; // if not used will lint fail
        $stageId; // if not used will lint fail
        $roundApi = new RoundApi;
        $round = $roundApi->getDetail($roundId)['data'];
        $round['status'] = $request->status;
        $roundApi->update($round, $roundId);

        return response()->json(['status' => $request->status]);
    }

    public function uploadRoundsFile(Request $req, $game, $stageId)
    {
        $game;
        $file = $req->file('excel_file');

        if (is_null($file)) {
            return redirect()->back()->withErrors([
                'error' => ['Silakan pilih file terlebih dahulu'],
            ]);
        }

        $theArray = Excel::toArray([], $file);

        if ($theArray[0][3][0] !== 'ID Babak') {
            return redirect()->back()->withErrors([
                'error' => ['Data tidak berhasil diunggah! Silakan download format data yang tersedia!'],
            ]);
        }

        $total_array = count($theArray[0]);
        $filter = [
            'filter[stage_id]' => $stageId,
            'per_page' => 99,
        ];
        $takeLastOrder = new RoundApi;
        $response = $takeLastOrder->index($filter);
        $rounds = $response['data'];

        if ($rounds !== null) {
            $round = [];
            foreach ($rounds as $key => $row) {
                $round[$key] = $row['order'];
            }

            array_multisort($round, SORT_DESC, $rounds);
            $lastOrder = $rounds[0]['order'];
        } else {
            $lastOrder = 0;
        }

        try {
            for ($i = 4; $i < $total_array; $i++) {
                $lastOrder++;
                $store = new RoundApi;
                $data = [
                    'stage_id' => $theArray[0][$i][0],
                    'title' => $theArray[0][$i][1],
                    'description' => $theArray[0][$i][4],
                    'direction' => $theArray[0][$i][6],
                    'material' => $theArray[0][$i][5],
                    'total_question' => $theArray[0][$i][2],
                    'question_timespan' => $theArray[0][$i][3],
                    'order' => $lastOrder,
                    'status' => 'NOT_PUBLISHED',
                ];
                $store = $store->store($data);
            }

            return redirect()->back()->with('success', 'Data berhasil diunggah!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors([
                'error' => [$e],
            ]);
        }
    }

    public function edit($stageId)
    {
        $roundApi = new RoundApi;
        $round = $roundApi->getDetail($stageId);

        return response()->json($round);
    }

    public function updateOrder(Request $request)
    {
        $this_id = $request->this_id;
        $to_id = $request->to_id;

        $roundApi = new RoundApi;

        $this_data = $roundApi->getDetail($this_id);
        $to_data = $roundApi->getDetail($to_id);

        $this_data_change = [
            'order' => $to_data['data']['order'],
        ];
        $to_data_change = [
            'order' => $this_data['data']['order'],
        ];

        $roundApi->update($this_data_change, $this_id);
        $roundApi->update($to_data_change, $to_id);

        echo 'success';
    }

    public function updateTitle(Request $request, $roundId)
    {
        $roundApi = new RoundApi;

        $payload = [
            'title' => $request->title,
        ];

        $response = $roundApi->update($payload, $roundId);

        if ($response['error']) {
            return redirect('/logout');
        }

        return redirect('/dashboard');
    }

    public function updateDirection(Request $request, $roundId)
    {
        $roundApi = new RoundApi;

        $payload = [
            'direction' => $request->direction,
        ];

        $response = $roundApi->update($payload, $roundId);

        if ($response['error']) {
            return redirect('/logout');
        }

        return redirect('/dashboard');
    }

    public function createRound(Request $request, $game, $stageId)
    {
        $game;
        $this->validate($request, [
            'title' => 'required',
            'question_showed' => 'required',
            'timespan' => 'required',
        ]);

        $roundApi = new RoundApi;

        $filter = [
            'filter[stage_id]' => $stageId,
            'per_page' => 99,
        ];

        $data = [
            'stage_id' => $stageId,
            'title' => $request->title,
            'description' => $request->description ?? 'tambahkan deskripsi', // database tidak nullable
            'direction' => $request->direction ?? 'tambahkan petunjuk', // database tidak nullable
            'material' => 'Buat Materi', // database tidak nullable
            'total_question' => $request->question_showed,
            'question_timespan' => $request->timespan,
            'order' => count($roundApi->index($filter)['data'] ?? []) + 1,
            'status' => 'NOT_PUBLISHED', // status unknown
        ];

        $roundApi->store($data);

        return redirect()->back()->with(['message' => 'Success!']);
    }

    public function uploadQuestionFile($game, $stageId, Request $req)
    {
        $game;
        $stageId;

        $file = $req->file('question_file');

        if (is_null($file) === true) {
            return redirect()->back()->withErrors([
                'error' => ['Silakan pilih file terlebih dahulu'],
            ]);
        }

        $data = Excel::toArray([], $file);

        try {
            if ($data[0][3][0] !== 'ID Ronde') {
                return redirect()->back()->withErrors([
                    'error' => ['Data tidak berhasil diunggah! Silakan download format data yang tersedia!'],
                ]);
            }

            $questionApi = new QuestionApi;
            $roundQuestionApi = new RoundQuestion;
            $roundApi = new RoundApi;

            for ($i=4; $i < count($data[0]); $i++) {
                $sheetIndex = 0;
                $row = $i;
                $roundIdIndex = 0;
                $questionIndex = 1;
                $answerIndex = 2;

                $collection = [
                    'owner' => 'KEJAR',
                    'subject_id'=> null,
                    'topic_id'=> null,
                    'bank'=> $this->gameDefault($game),
                    'type'=> 'MCQSA',
                    'question'=> (string)$data[$sheetIndex][$row][$questionIndex],
                    'choices'=> null,
                    'answer'=> (string)$data[$sheetIndex][$row][$answerIndex],
                    'level'=> 'LEVEL_1',
                    'status' => '2',
                    'created_by'=> session('user.id'),
                ];

                $question = $questionApi->store($collection);
                $questionApi->update($question['data']['id'], ['status' => '2']);

                $roundQuestionMeta = $roundQuestionApi
                                ->getAll($data[$sheetIndex][$row][$roundIdIndex], $req->page ?? 1)['meta'] ?? [];
                $questionTotal = $roundQuestionMeta['total'] ?? 0;

                $payloadQS = [
                    'question_id' => $question['data']['id'],
                    'round_id' => $data[$sheetIndex][$row][$roundIdIndex],
                    'order' => $questionTotal + 1,
                ];

                $roundQuestionApi->store($question['data']['id'], $payloadQS);

                $roundData = [
                    'status' => 'PUBLISHED',
                ];
                $roundApi->update($roundData, $data[$sheetIndex][$row][$roundIdIndex]);
            }
        } catch (Throwable $th) {
            return $th;
        }

        return redirect()->back()->with('success', 'Soal berhasil ditambahkan!');
    }

    private function gameDefault($game)
    {
        switch ($game) {
            case 'OBR':
                return 'OBR';

                break;
            case 'KATABAKU':
                return 'Kata Baku';

                break;
            case 'VOCABULARY':
                return 'Vocabulary';

                break;
            default:
                return $game;

                break;
        }
    }
}
