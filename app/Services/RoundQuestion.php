<?php

namespace App\Services;

use Illuminate\Http\Request;

class RoundQuestion extends Service {

    public function getAll($roundId, $page = 1){
        $response = $this->get("/matrikulasi/libraries/rounds/$roundId/questions", "page=$page");
        return $this->showResponse($response);
    }

    public function store($roundId, $payload)
    {
        $response = $this->post("/matrikulasi/libraries/rounds/$roundId/questions", $payload);
        return $this->showResponse($response);
    }

    public function getDetail($roundId, $roundQuestionId)
    {
        $response = $this->get("/matrikulasi/libraries/rounds/$roundId/questions/$roundQuestionId");
        return $this->showResponse(($response));
    }

}
