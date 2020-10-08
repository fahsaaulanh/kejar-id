<?php

namespace App\Services;

class MiniAssessment extends Service
{
    public function detail($id)
    {
        $response = $this->get('/libraries/mini-assessments/'.$id);

        return $this->showResponse($response);
    }

    public function answers($id)
    {
        $response = $this->get('/libraries/mini-assessments/'.$id.'/answers', 'per_page=99');

        return $this->showResponse($response);
    }

    public function saveAnswer($id, $payload)
    {
        $response = $this->post('/libraries/mini-assessments/'.$id.'/answers', $payload);

        return $this->showResponse($response);
    }

    public function index($filter = '')
    {
        $response = $this->get('/libraries/mini-assessments', $filter);

        return $this->showResponse($response);
    }

    public function create($file, $payload)
    {
        $response = $this->postWithFile('/libraries/mini-assessments', $file, $payload);

        return $this->showResponse($response);
    }
}
