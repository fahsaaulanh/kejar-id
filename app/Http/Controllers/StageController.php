<?php

namespace App\Http\Controllers;

use App\Imports\StagesImport;
use Illuminate\Http\Request;
use App\Services\Stage as StageApi;
use Excel;
use Exception;
use Rap2hpoutre\FastExcel\FastExcel;

class StageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $game)
    {
        $stage = new StageApi();

        if ($game == "OBR") {
            $game = [
                'short' => 'OBR',
                'title' => 'Operasi Bilangan Rill',
                'uri' => 'OBR'
            ];

        } else if($game == "VOCABULARY"){
            $game = [
                'short' => 'Vocabulary',
                'title' => 'VOCABULARY',
                'uri' => 'VOCABULARY'
            ];

        } else if($game == "KATABAKU"){
            $game = [
                'short' => 'Kata Baku',
                'title' => 'KATA BAKU',
                'uri' => 'KATABAKU'
            ];
        } else{
            abort(404);
        }

        // Get All Stages Data
        $stages = $stage->getAll($game['uri'])['data'];
        // Sorting Stages
        $stages = $this->aasort($stages, 'order');

        return view('stage.index', compact('stages', 'game'));
    }

    public function upload(Request $request, $game)
    {
        
        $this->validate($request, [
            'stage_file' => 'required|file'
        ]); 

        if ($request->file('stage_file')->getClientOriginalExtension() != 'xlsx') {
            return redirect()->back();
        }

        $file = $request->file('stage_file');

        try {
            $data = Excel::toArray([], $file);

            for ($i=4; $i < count($data[0]); $i++) {
                $stage = new StageApi();

                $stages = $stage->getAll($game)['data'];
                $stagesSum = $stages == null ? 0 : count($stages);

                $collection = [
                    // 'number' => $data[0][$i][0],
                    'title' => $data[0][$i][1],
                    'game' => $data[0][0][1],
                    'description' => $data[0][$i][2],
                    'order' => $stagesSum + 1
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
        $stage = new StageApi();

        $stageDetail = $stage->show($game, $stageId)['data'];

        $payload = [
            'title' => $stageDetail['title'],
            'game' => $stageDetail['game'],
            'description' => $stageDetail['description'],
            'order' => $request->order,
        ];

        $stage = $stage->reorder($game, $stageId, $payload);

        
        return response()->json($stage);
    }

    private function aasort($array, $key) {
        if($array != null){
            $sorter=array();
            $ret=array();
            reset($array);
            foreach ($array as $ii => $va) {
                $sorter[$ii]=$va[$key];
            }
            asort($sorter);
            foreach ($sorter as $ii => $va) {
                $ret[$ii]=$array[$ii];
            }
            $array=$ret;
        }
        else {
            $array = [];
        }

        return $array;
    }


}
