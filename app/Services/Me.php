<?php

namespace App\Services;

class Me extends Service
{
    public function update($payload)
    {
        $response = $this->patch('/me', $payload);

        return $this->showResponse($response);
    }

    public function me()
    {
        $response = $this->get('/me');

        return $this->showResponse($response);
    }

    public function tasks($filter = [])
    {
        $response = $this->get('/me/tasks', $filter);

        return $this->showResponse($response);
    }

    public function getAssessmentSchedules($filter = [])
    {
        $response = $this->get('/me/schedules/assessments', $filter);

        return $this->showResponse($response);
    }

    public function assessmentScheduleDetail($id)
    {
        $response = $this->get("/me/schedules/assessments/$id");

        return $this->showResponse($response);
    }
}
