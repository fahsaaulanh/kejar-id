<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        // Get All Stages Data
        $stages = $stage->getAll($game['uri'])['data'] ?? [];
        // Sorting Stages
        // $stages = $this->aasort($stages, 'order');

        return view('admin.stage.index', compact('stages', 'game'));
    }

    public function upload(Request $request, $game)
    {

        $this->validate($request, [
            'stage_file' => 'required|file',
        ]);

        if ($request->file('stage_file')->getClientOriginalExtension() !== 'xlsx') {
            return redirect()->back();
        }

        $file = $request->file('stage_file');

        try {
            $data = Excel::toArray([], $file);

            for ($i=4; $i < count($data[0]); $i++) {
                $stage = new StageApi;

                $stages = $stage->getAll($game)['data'];
                $stagesSum = $stages === null ? 0 : count($stages);

                $collection = [
                    // 'number' => $data[0][$i][0],
                    'title' => $data[0][$i][1],
                    'game' => $data[0][0][1],
                    'description' => $data[0][$i][2],
                    'order' => $stagesSum + 1,
                    // 'note' => $data[0][$i][3],
                ];

                $stage->store($game, $collection);
            }
        } catch (Exception $e) {
            return $e;
        }

        return redirect()->back()->with('message', 'Success!');
    }

    public function order($game, $stageId, Request $request)
    {
        $stage = new StageApi;

        $stageDetail = $stage->getDetail($game, $stageId)['data'];

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

    // private function aasort($array, $key)
    // {
    //     if ($array !== null) {
    //         $sorter=[];
    //         $ret=[];
    //         reset($array);
    //         foreach ($array as $ii => $va) {
    //             $sorter[$ii]=$va[$key];
    //         }

    //         asort($sorter);
    //         foreach ($sorter as $ii) {
    //             $ret[$ii]=$array[$ii];
    //         }

    //         $array=$ret;
    //     } else {
    //         $array = [];
    //     }

    //     return $array;
    // }
}
