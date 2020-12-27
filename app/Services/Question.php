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

    public function update($id, $payload)
    {
        $response = $this->patch('/libraries/questions/'.$id, $payload);

        return $this->showResponse($response);
    }

    public function uploadImage($file)
    {
        $response = $this->postUploadImage('/libraries/questions/image-upload', $file, []);

        return $response->json();
    }
}
