<?php

namespace App\Http\Controllers\Round;

use App\Http\Controllers\Controller;
use App\Services\Question;
use App\Services\Round as RoundApi;
use App\Services\Stage as StageApi;
use App\Services\RoundQuestion;
use Illuminate\Http\Request;
use Excel;
use Exception;

class RoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($game, $stageId, $roundId, Request $request)
    {

        $roundApi = new RoundApi();
        $round = $roundApi->getDetail($roundId)['data'] ?? null;
        if ($round == null) {
            abort('404');
        }

        $stageApi = new StageApi();
        $stage = $stageApi->getDetail($game, $stageId)['data'] ?? null;

        $roundQuestionApi = new RoundQuestion();
        $roundQuestions = $roundQuestionApi->getAll($roundId, $request->page ?? 1);
        $roundQuestionsData = $roundQuestions['data'] ?? [];
        $roundQuestionsMeta = $roundQuestions['meta'] ?? [];

        // dd($roundQuestionsMeta);

        $questionApi = new Question();

        $questions = [];
        for ($i=0; $i < count($roundQuestionsData); $i++) {
            $question = $questionApi->getDetail($roundQuestionsData[$i]['question_id']);
            if ($question['data'] ?? null) {
                $roundQuestionsData[$i]['question'] =  $question['data'];
            }
        }

        if ($game == "OBR") { $game = ['short' => 'OBR','title' => 'Operasi Bilangan Rill','uri' => 'OBR']; } else if($game == "VOCABULARY"){ $game = ['short' => 'Vocabulary', 'title' => 'VOCABULARY', 'uri' => 'VOCABULARY']; } else if($game == "KATABAKU"){ $game = ['short' => 'Kata Baku','title' => 'KATA BAKU','uri' => 'KATABAKU']; } else{ abort(404); }


        return view('ronde.index', compact('game', 'stageId', 'stage', 'roundId', 'round', 'roundQuestionsData', 'roundQuestionsMeta'));
    }

    public function updateStatus(Request $request, $game, $stageId, $roundId)
    {
        $roundApi = new RoundApi();
        $round = $roundApi->getDetail($roundId)['data'];
        $round['status'] = $request->status;
        $roundApi->update($round, $roundId);

        return response()->json(['status' => $request->status]);
    }

    public function uploadFile($game, $stageId, $roundId, Request $request)
    {
        $this->validate($request, [
            'question_file' => 'required'
        ]);

        $file = $request->file('question_file');

        try {
            $data = Excel::toArray([], $file);;

            for ($i=4; $i < count($data[2]); $i++) {
                $collection = [
                    "subject_id"=> null,
                    "topic_id"=> null,
                    "bank"=> $data[2][0][1],
                    "type"=> "MCQSA",
                    "question"=> $data[2][$i][1],
                    "choices"=> [],
                    "answer"=> $data[2][$i][2],
                    "level"=> "LEVEL_1",
                    "created_by"=> session('user')['id'],
                ];


                $questionApi = new Question();
                $question = $questionApi->store($collection);

                $roundQuestionApi = new RoundQuestion();
                $roundQuestionApi->store($roundId, [
                    "question_id" => $question['data']['id'],
                    "round_id" => $roundId,
                    "order" => $roundQuestionApi->getAll($roundId)['meta']['total'] + 1,
                ]);

            }
        } catch (Exception $e) {
            return $e;
        }


        return redirect()->back()->with(['message', 'Success']);
    }
}
