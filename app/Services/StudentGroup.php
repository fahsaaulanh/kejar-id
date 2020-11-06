<?php

namespace App\Services;

class StudentGroup extends Service
{
    public function index($schoolId, $batchId, $filter = [])
    {
        $response = $this->get("/schools/$schoolId/batches/$batchId/student-groups", $filter);

        return $this->showResponse($response);
    }

    public function detail($schoolId, $batchId, $id)
    {
        $response = $this->get("/schools/$schoolId/batches/$batchId/student-groups/$id");

        return $this->showResponse($response);
    }

    public function detailWithoutBatch($id)
    {
        $response = $this->get("/schools/student-groups/$id");

        return $this->showResponse($response);
    }
}
