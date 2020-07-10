<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Question as QuestionApi;
use App\Services\Round as RoundApi;
use App\Services\Stage as StageApi;
use App\Services\RoundQuestion;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class QuestionController extends Controller
{

    public function index($game, $stageId, $roundId, Request $request)
    {

        $roundApi = new RoundApi();
        $round = $roundApi->getDetail($roundId)['data'] ?? null;
        if ($round == null) {
            abort('404');
        }

        $stageApi = new StageApi();
        $stage = $stageApi->show($game, $stageId)['data'] ?? null;

        $roundQuestionApi = new RoundQuestion();
        $roundQuestions = $roundQuestionApi->getAll($roundId, $request->page ?? 1);
        $roundQuestionsData = $roundQuestions['data'] ?? [];
        $roundQuestionsMeta = $roundQuestions['meta'] ?? [];

        $questionApi = new QuestionApi();

        $questions = [];
        for ($i=0; $i < count($roundQuestionsData); $i++) {
            $question = $questionApi->getDetail($roundQuestionsData[$i]['question_id']);
            if ($question['data'] ?? null) {
                $roundQuestionsData[$i]['question'] =  $question['data'];
            }
        }

        if ($game == "OBR") { $game = ['short' => 'OBR','title' => 'Operasi Bilangan Rill','uri' => 'OBR']; } else if($game == "VOCABULARY"){ $game = ['short' => 'Vocabulary', 'title' => 'VOCABULARY', 'uri' => 'VOCABULARY']; } else if($game == "KATABAKU"){ $game = ['short' => 'Kata Baku','title' => 'KATA BAKU','uri' => 'KATABAKU']; } else{ abort(404); }


        return view('admin.question.index', compact('game', 'stageId', 'stage', 'roundId', 'round', 'roundQuestionsData', 'roundQuestionsMeta'));
    }

    public function uploadFile(Request $request, $game)
    {
        $this->validate($request, [
            'question_file' => 'required'
        ]);

        $file = $request->file('question_file');
        $data = Excel::toArray([], $file);;
        try {


            for ($i=4; $i < count($data[2]); $i++) {
                $collection = [
                    "subject_id"=> null,
                    "topic_id"=> null,
                    "bank"=> $game,
                    "type"=> "MCQSA",
                    "question"=> (string)$data[2][$i][1],
                    "choices"=> [],
                    "answer"=> (string)$data[2][$i][2],
                    "level"=> "LEVEL_1",
                    "created_by"=> session('user')['id'],
                ];


                $questionApi = new QuestionApi();
                $question = $questionApi->store($collection);

                $payloadQS = [
                    "question_id" => $question['data']['id'],
                    "round_id" => $data[2][$i][0],
                    "order" => 1
                ];

                $roundQuestionApi = new RoundQuestion();
                $roundQuestionApi->store($data[2][$i][0], $payloadQS);

            }
        } catch (Exception $e) {
            return $e;
        }


        return redirect()->back()->with(['message', 'Success']);
    }


    public function storeQuestion(Request $request, $game, $stageId, $roundId)
    {
        $user = session('user');
        $questionApi = new QuestionApi;
        $roundQuestionApi = new RoundQuestion;
        $data = $request->input('question');

        $questionIds = [];
            foreach($data as $questions){
                $payload = [
                    "subject_id" => null,
                    "topic_id" => null,
                    "bank" => $game,
                    "type" => "MCQSA",
                    "question" => $questions['question'],
                    "choices" => null,
                    "answer" => $questions['answer'],
                    "level" => "LEVEL_1",
                    "created_by" =>  $user['id']
                ];

                $response = $questionApi->store($payload);
                $payloadQS = [
                    "question_id" => $response['data']['id'],
                    "round_id" => $roundId,
                    "order" => 1
                ];
                $resQS = $roundQuestionApi->store($roundId, $payloadQS);
            }

            if (!$response['error']) {
                return redirect()->back()->with('message', 'Success!');
            }

            return redirect('/dashboard');

    }
}
