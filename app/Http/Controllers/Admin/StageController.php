<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Game;
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
        $filter = [
            'per_page' => 99,
        ];

        $stages = $stage->getAll($game, $filter)['data'] ?? [];

        $gameService = new Game;
        $game = $gameService->parse($game);

        $stagesCount = count($stages);

        return view('admin.stages.index', compact('stages', 'game', 'stagesCount'));
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
                    'stage_file' => ['Data tidak berhasil diunggah. Silakan download format data yang tersedia.'],
                ]);
            }

            $stageApi = new StageApi;
            $stages = $stageApi->getAll($game)['data'] ?? [];
            $stagesSum = $stages[count($stages) - 1]['order'] ?? 0;

            for ($i=4; $i < count($data[0]); $i++) {
                $sheetIndex = 0;
                $row = $i;
                $title = 0;
                $description = 1;
                $stagesSum += 1;

                $collection = [
                    'title' => $data[$sheetIndex][$row][$title],
                    'game' => $game,
                    'description' => $data[$sheetIndex][$row][$description],
                    'order' => $stagesSum,
                ];

                $stageApi->store($game, $collection);
            }
        } catch (Exception $e) {
            return $e;
        }

        return redirect()->back()->with('success', 'Babak berhasil ditambahkan.');
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
                    'round_file' => ['Data tidak berhasil diunggah. Silakan download format data yang tersedia.'],
                ]);
            }

            for ($i=4; $i < count($data[0]); $i++) {
                $roundApi = new RoundApi;
                $filter = [
                    'filter[stage_id]' => $data[0][$i][0],
                    'per_page' => 99,
                ];

                $rounds = $roundApi->index($filter)['data'] ?? [];
                if ($rounds !== null) {
                    $round = [];
                    foreach ($rounds as $key => $row) {
                        $round[$key] = $row['order'];
                    }

                    array_multisort($round, SORT_DESC, $rounds);
                    $roundsSum = $rounds[0]['order'];
                } else {
                    $roundsSum = 0;
                }

                $sheetIndex = 0;
                $row = $i;

                $collection = [
                    'stage_id' => $data[$sheetIndex][$row][0],
                    'title' => $data[$sheetIndex][$row][1],
                    'total_question' => $data[$sheetIndex][$row][2],
                    'question_timespan' => $data[$sheetIndex][$row][3],
                    'description' => $data[$sheetIndex][$row][4],
                    'material' => $data[$sheetIndex][$row][5] ?? 'Buat materi',
                    'direction' => $data[$sheetIndex][$row][6],
                    'order' => $roundsSum += 1,
                    'status' => 'NOT_PUBLISHED',
                ];

                $roundApi->store($collection);
            }
        } catch (Exception $e) {
            return $e;
        }

        return redirect()->back()->with('success', 'Ronde berhasil ditambahkan!!');
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
        $stages = $stageApi->getAll($game)['data'] ?? [];
        $stageOrder = $stages[count($stages) - 1]['order'] ?? 0;
        $payload = [
            'title' => $request->title,
            'description' => $request->description,
            'game' => $game,
            'order' => $stageOrder += 1,
        ];

        $stageApi->store($game, $payload);

        return redirect()->back()->with(['message' => 'Berhasil!']);
    }

    // Update Stage Modal
    public function updateStageModal(Request $req, $game, $stageId)
    {
        $stageApi = new StageApi;
        $game = strtoupper($game);
        $editData = $stageApi->getDetail($game, $stageId)['data'] ?? [];

        $payload = [
            'title' => $req->title ?? $editData['title'],
            'game' => $editData['game'],
            'description' => $req->description ?? $editData['description'],
            'order' => $editData['order'],
        ];

        $stageApi->reorder($game, $stageId, $payload);

        return redirect()->back();
    }
}
