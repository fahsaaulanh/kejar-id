<?php

namespace App\Services;

class StudentCounselor extends Service
{
    public function index($schoolId, $filter = [])
    {
        $response = $this->get("/schools/$schoolId/student-counselors", $filter);

        return $this->showResponse($response);
    }

    public function detail($schoolId, $id)
    {
        $response = $this->get("/schools/$schoolId/student-counselors/$id");

        return $this->showResponse($response);
    }
}
