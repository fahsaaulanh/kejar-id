<?php

namespace App\Services;

class Batch extends Service
{

    public function index($schoolId, $filter = [])
    {
        $response = $this->get("/schools/$schoolId/batches", $filter);

        return $this->showResponse($response);
    }
}
