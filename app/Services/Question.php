<?php

namespace App\Services;

class Question extends Service
{

    public function getDetail($questionId)
    {
        $response = $this->get("/libraries/questions/$questionId");

        return $this->showResponse($response);
    }

    public function store($payload)
    {
        $response = $this->post('/libraries/questions', $payload);

        return $this->showResponse($response);
    }
}
