<?php

namespace App\Services;

class Task extends Service
{
    public function index()
    {
        $response = $this->get('/tasks/matrikulasi');

        return $this->showResponse($response);
    }

    public function getAll($game)
    {
        $response = $this->get("/matrikulasi/games/$game/stages");

        return $this->showResponse($response);
    }

    public function start($stageId, $roundId)
    {
        $data = [
            'stage_id' => $stageId,
            'round_id' => $roundId,
        ];

        $response = $this->post('/tasks/matrikulasi', $data);

        return $this->showResponse($response);
    }

    public function question($taskId)
    {
        $response = $this->get("/tasks/matrikulasi/$taskId/answers");

        return $this->showResponse($response);
    }

    public function detail($taskId)
    {
        $response = $this->get("/tasks/matrikulasi/$taskId");

        return $this->showResponse($response);
    }

    public function answer($taskId, $answerId, $answer)
    {
        $payload = [
            'answer' => $answer,
        ];
        $response = $this->patch("/tasks/matrikulasi/$taskId/answers/$answerId", $payload);

        return $this->showResponse($response);
    }

    public function finish($taskId)
    {
        $response = $this->patch("/tasks/matrikulasi/$taskId");

        return $this->showResponse($response);
    }
}
