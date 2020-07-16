<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Round as RoundApi;
use App\Services\Stage as StageApi;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($game)
    {
        $stage = new StageApi;

        $game = strtoupper($game);

        $game = $this->getGame($game);
        
        $stages = $stage->getAll($game['uri'])['data'] ?? [];

        return view('admin.stages.index', compact('stages', 'game'));
    }

    public function upload(Request $request, $game)
    {

        $this->validate($request, [
            'stage_file' => 'required|file',
        ]);

        $game = strtoupper($game);

        if ($request->file('stage_file')->getClientOriginalExtension() !== 'xlsx') {
            return redirect()->back();
        }

        $file = $request->file('stage_file');

        try {
            $data = Excel::toArray([], $file);

            if ($data[0][3][0] !== 'Judul Babak') {
                return redirect()->back()->withErrors([
                    'stage_file' => ['Data tidak berhasil diunggah! Silakan download format data yang tersedia!'],
                ]);
            }

            $stageApi = new StageApi;
            $stages = $stageApi->getAll($game)['data'] ?? [];
            $stagesSum = $stages === null ? 0 : count($stages);
            
            for ($i=4; $i < count($data[0]); $i++) {
                $sheetIndex = 0;
                $row = $i;
                $title = 0;
                $description = 1;
                $game = $data[$sheetIndex][0][1];

                $collection = [
                    'title' => $data[$sheetIndex][$row][$title],
                    'game' => $game,
                    'description' => $data[$sheetIndex][$row][$description],
                    'order' => $stagesSum + 1,
                ];

                $stageApi->store($game, $collection);
            }
        } catch (Exception $e) {
            return $e;
        }

        return redirect()->back()->with('message', 'Success!');
    }

    public function uploadRounds(Request $request, $game)
    {
        $game = strtoupper($game);
        $this->validate($request, [
            'round_file' => 'required|file',
        ]);

        if ($request->file('round_file')->getClientOriginalExtension() !== 'xlsx') {
            return redirect()->back();
        }

        $file = $request->file('round_file');

        try {
            $data = Excel::toArray([], $file);

            if ($data[0][3][0] !== 'ID Babak') {
                return redirect()->back()->withErrors([
                    'round_file' => ['Data tidak berhasil diunggah! Silakan download format data yang tersedia!'],
                ]);
            }

            for ($i=4; $i < count($data[0]); $i++) {
                $roundApi = new RoundApi;
                $filter = '?filter[stage_id]=' . $data[0][$i][0];
                $rounds = $roundApi->index($filter)['data'] ?? [];
                $roundsSum = $rounds === null ? 0 : count($rounds);

                $sheetIndex = 0;
                $row = $i;

                $collection = [
                    'stage_id' => $data[$sheetIndex][$row][0],
                    'title' => $data[$sheetIndex][$row][1],
                    'total_question' => $data[$sheetIndex][$row][2],
                    'question_timespan' => $data[$sheetIndex][$row][3],
                    'description' => $data[$sheetIndex][$row][4],
                    'material' => $data[$sheetIndex][$row][5] ?? 'Buat Materi',
                    'direction' => $data[$sheetIndex][$row][6],
                    'order' => $roundsSum + 1,
                    'status' => 'NOT_PUBLISHED',
                ];

                $roundApi->store($collection);
            }
        } catch (Exception $e) {
            return $e;
        }

        return redirect()->back()->with('message', 'Success!');
    }

    public function order($game, $stageId, Request $request)
    {
        $stage = new StageApi;
        $game = strtoupper($game);

        $stageDetail = $stage->getDetail($game, $stageId)['data'] ?? [];

        $payload = [
            'title' => $stageDetail['title'],
            'game' => $stageDetail['game'],
            'description' => $stageDetail['description'],
            'order' => $request->order,
        ];

        $stage = $stage->reorder($game, $stageId, $payload);

        return response()->json($stage);
    }

    public function create(Request $request, $game)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);
        
        $game = strtoupper($game);
        $stageApi = new StageApi;
        $payload = [
            'title' => $request->title,
            'description' => $request->description,
            'game' => $game,
            'order' => count($stageApi->getAll($game)['data'] ?? []) + 1,
        ];

        $stageApi->store($game, $payload);

        return redirect()->back()->with(['message' => 'Success!']);
    }

    private function getGame($game)
    {
        if ($game === 'OBR') {
            $game = [
                'short' => 'OBR',
                'title' => 'Operasi Bilangan Rill',
                'uri' => 'OBR',
            ];
        } elseif ($game === 'VOCABULARY') {
            $game = [
                'short' => 'Vocabulary',
                'title' => 'VOCABULARY',
                'uri' => 'VOCABULARY',
            ];
        } elseif ($game === 'KATABAKU') {
            $game = [
                'short' => 'Kata Baku',
                'title' => 'KATA BAKU',
                'uri' => 'KATABAKU',
            ];
        } else {
            abort(404);
        }

        return $game;
    }
}
