<?php

namespace App\Services;

use Illuminate\Http\Request;

class Stage extends Service {

    public function getAll($game)
    {
        $response = $this->get("/matrikulasi/games/$game/stages");
        return $this->showResponse($response);
    }

    public function store($game, $payload)
    {
        $response = $this->post("/matrikulasi/games/$game/stages", $payload);
        return $this->showResponse($response);
    }

    public function getDetail($game, $stageId)
    {
        $response = $this->get("/matrikulasi/games/$game/stages/$stageId");
        return $this->showResponse($response);
    }

    public function reorder($game, $stageId, $payload)
    {
        $response = $this->patch("/matrikulasi/games/$game/stages/$stageId" , $payload);
        return $this->showResponse($response);
    }
}
