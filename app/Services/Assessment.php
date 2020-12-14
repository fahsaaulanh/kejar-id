<?php

namespace App\Services;

class Assessment extends Service
{
    public function detail($id, $filter = [])
    {
        $response = $this->get('/libraries/assessments/'.$id, $filter);

        return $this->showResponse($response);
    }

    public function answers($id)
    {
        $response = $this->get('/libraries/assessments/'.$id.'/answers', 'per_page=99');

        return $this->showResponse($response);
    }

    public function questions($id, $page = 1)
    {
        $response = $this->get('/libraries/assessments/'.$id.'/questions', "page=$page");

        return $this->showResponse($response);
    }

    public function createQuestion($id, $payload)
    {
        $response = $this->post('/libraries/assessments/'.$id.'/questions', $payload);

        return $this->showResponse($response);
    }

    public function editQuestion($id, $payload)
    {
        $response = $this->patch('/libraries/assessments/'.$id.'/questions', $payload);

        return $this->showResponse($response);
    }

    public function saveAnswer($id, $payload)
    {
        $response = $this->post('/libraries/assessments/'.$id.'/answers', $payload);

        return $this->showResponse($response);
    }

    public function updateAnswer($miniAssessmentId, $id, $payload)
    {
        $response = $this->patch('/libraries/assessments/'.$miniAssessmentId.'/answers/'.$id, $payload);

        return $this->showResponse($response);
    }

    public function index($filter = [])
    {
        $response = $this->get('/libraries/assessments', $filter);

        return $this->showResponse($response);
    }

    public function create($file, $payload)
    {
        $response = $this->postWithFile('/libraries/assessments', $file, $payload);

        return $this->showResponse($response);
    }

    public function update($id, $payload)
    {
        $response = $this->patch('/libraries/assessments/'.$id, $payload);

        return $this->showResponse($response);
    }

    public function updateValidation($id, $payload)
    {
        $response = $this->patch('/libraries/assessments/' . $id, $payload);

        return $this->showResponse($response);
    }

    public function result($id, $filter = [])
    {
        $response = $this->get('/tasks/assessments/students/'.$id, $filter);

        return $this->showResponse($response);
    }

    public function updateFinalScore($id, $payload)
    {
        $response = $this->patch('/tasks/assessments/'.$id.'/evaluate/', $payload);

        return $this->showResponse($response);
    }

    public function updateNote($id, $payload)
    {
        $response = $this->patch('/tasks/assessments/'.$id.'/note', $payload);

        return $this->showResponse($response);
    }

    public function report($filter = [])
    {
        $response = $this->get('reports/assessments', $filter);

        return $this->showResponse($response);
    }
}
