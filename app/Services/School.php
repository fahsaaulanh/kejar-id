<?php

namespace App\Services;

class School extends Service
{
    public function subjectIndex($schoolId)
    {
        $response = $this->get("/schools/$schoolId/subjects");

        return $this->showResponse($response);
    }

    public function subjectDetail($schoolId, $subjectId)
    {
        $response = $this->get("/schools/$schoolId/subjects/$subjectId");

        return $this->showResponse($response);
    }

    public function detail($schoolId)
    {
        $response = $this->get("/schools/$schoolId");

        return $this->showResponse($response);
    }
}
