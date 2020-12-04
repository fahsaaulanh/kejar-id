<?php

namespace App\Services;

class Schedule extends Service
{
    public function index($schoolId, $filter = [])
    {
        $response = $this->get("/schools/$schoolId/schedules", $filter);

        return $this->showResponse($response);
    }

    public function bulkCreate($schoolId, $payload)
    {
        $response = $this->post("/schools/$schoolId/schedules/bulk-create", $payload);

        return $this->showResponse($response);
    }

    public function update($schoolId, $payload)
    {
        $response = $this->patch("/schools/$schoolId/schedules/bulk-update", $payload);

        return $this->showResponse($response);
    }
}
