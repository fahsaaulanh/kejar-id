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

    public function startMiniAssessment($miniAssessmentId)
    {

        $payload = [
            'mini_assessment_id' => $miniAssessmentId,
        ];

        $response = $this->post('/tasks/mini-assessments', $payload);

        return $this->showResponse($response);
    }

    public function questionsMiniAssessment($miniAssessmentsId)
    {
        $filter = [
            'per_page' => 99,
        ];

        $response = $this->get("/libraries/mini-assessments/$miniAssessmentsId/answers", $filter);

        return $this->showResponse($response);
    }

    public function answersMiniAssessment($maTaskId)
    {
        $response = $this->get("/tasks/mini-assessments/$maTaskId/answers");

        return $this->showResponse($response);
    }

    public function setAnswerMiniAssessment($maTaskId, $answerId, $payload)
    {
        $response = $this->patch("/tasks/mini-assessments/$maTaskId/answers/$answerId", $payload);

        return $this->showResponse($response);
    }

    public function finishMiniAssessment($maTaskId)
    {
        $response = $this->patch("/tasks/mini-assessments/$maTaskId");

        return $this->showResponse($response);
    }

    public function tasksMiniAssessment($studentId, $filter = [])
    {
        $response = $this->get("/tasks/mini-assessments/students/$studentId", $filter);

        return $this->showResponse($response);
    }
}
