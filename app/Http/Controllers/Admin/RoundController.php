<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\Stage as StageApi;
use App\Services\Round as RoundApi;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class RoundController extends Controller
{
    public function index($game, $stageId)
    {
        $stagesApi = new StageApi();
        $response = $stagesApi->show($game, $stageId);
        $stage = $response['data'];

        $roundApi = new RoundApi();
        $response = $roundApi->index();
        $rounds = $response['data'];

        if($rounds != ''){
            $round = array();
            foreach ($rounds as $key => $row)
            {
                $round[$key] = $row['order'];
            }
            array_multisort($round, SORT_ASC, $rounds);
        }else{
            $rounds = '';
        }

        if ($game == "OBR") { $game = ['short' => 'OBR','title' => 'Operasi Bilangan Rill','uri' => 'OBR']; } else if($game == "VOCABULARY"){ $game = ['short' => 'Vocabulary', 'title' => 'VOCABULARY', 'uri' => 'VOCABULARY']; } else if($game == "KATABAKU"){ $game = ['short' => 'Kata Baku','title' => 'KATA BAKU','uri' => 'KATABAKU']; } else{ abort(404); }

        return view('admin/round/index', compact('game', 'stage', 'rounds'));
    }

    public function updateStatus(Request $request, $game, $stageId, $roundId)
    {
        $roundApi = new RoundApi();
        $round = $roundApi->getDetail($roundId)['data'];
        $round['status'] = $request->status;
        $roundApi->update($round, $roundId);

        return response()->json(['status' => $request->status]);
    }

    public function uploadFile(Request $req)
    {
        $file = $req->file('excel_file');
        $theArray = Excel::toArray([], $file);
        $total_array = count($theArray[1]);
        $takeLastOrder = new RoundApi;
        $response = $takeLastOrder->index();
        $rounds = $response['data'];

        if($rounds != ''){
            $round = array();
            foreach ($rounds as $key => $row)
            {
                $round[$key] = $row['order'];
            }
            array_multisort($round, SORT_DESC, $rounds);
            $lastOrder = $rounds[0]['order'];
        }else{
            $lastOrder = 0;
        }

        try{
            for ($i = 4; $i < $total_array; $i++) {
                $lastOrder += 1;
                $store = new RoundApi;
                $data = [
                    'id' => $theArray[1][$i][1],
                    'stage_id' => $theArray[1][$i][0],
                    'title' => $theArray[1][$i][2],
                    'description' => $theArray[1][$i][5],
                    'direction' => $theArray[1][$i][7],
                    'material' => $theArray[1][$i][6],
                    'total_question' => $theArray[1][$i][3],
                    'question_timespan' => $theArray[1][$i][4],
                    'order' => $lastOrder,
                    'status' => 'NOT_PUBLISHED'
                ];
                $store = $store->store($data);
            }

            return back();
        }catch(Exception $e){
            return back();
        }
    }

    public function edit($stageId)
    {
        $roundApi = new RoundApi();
        $round = $roundApi->getDetail($stageId);

        return response()->json($round);
    }

    public function updateOrder(Request $request)
    {
        $this_id = $request->this_id;
        $to_id = $request->to_id;

        $roundApi = new RoundApi();

        $this_data = $roundApi->getDetail($this_id);
        $to_data = $roundApi->getDetail($to_id);

        $this_data_change = [
            'id' => $this_data['data']['id'],
            'stage_id' => $this_data['data']['stage_id'],
            'title' => $this_data['data']['title'],
            'description' => $this_data['data']['description'],
            'direction' => $this_data['data']['direction'],
            'material' => $this_data['data']['material'],
            'total_question' => $this_data['data']['total_question'],
            'question_timespan' => $this_data['data']['question_timespan'],
            'order' => $to_data['data']['order'],
            'status' => $this_data['data']['status']
        ];
        $to_data_change = [
            'id' => $to_data['data']['id'],
            'stage_id' => $to_data['data']['stage_id'],
            'title' => $to_data['data']['title'],
            'description' => $to_data['data']['description'],
            'direction' => $to_data['data']['direction'],
            'material' => $to_data['data']['material'],
            'total_question' => $to_data['data']['total_question'],
            'question_timespan' => $to_data['data']['question_timespan'],
            'order' => $this_data['data']['order'],
            'status' => $to_data['data']['status']
        ];

        $roundApi->update($this_data_change, $this_id);
        $roundApi->update($to_data_change, $to_id);

        echo "success";
    }

    public function updateTitle(Request $request, $roundId)
    {
        $roundApi = new RoundApi;

        $payload = [
            "title" => $request->title
        ];

        $response = $roundApi->update($payload, $roundId);

        if($response['error']) {
            return redirect('/logout');
        }

        return redirect('/dashboard');
    }

    public function updateDirection(Request $request, $roundId)
    {
        $roundApi = new RoundApi;

        $payload = [
            "direction" => $request->direction
        ];

        $response = $roundApi->update($payload, $roundId);

        if($response['error']) {
            return redirect('/logout');
        }

        return redirect('/dashboard');
    }
}
