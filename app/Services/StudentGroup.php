<?php

namespace App\Services;

class StudentGroup extends Service
{
    public function index($schoolId, $batchId, $filter = [])
    {
        $response = $this->get("/schools/$schoolId/batches/$batchId/student-groups", $filter);

        return $this->showResponse($response);
    }
}
