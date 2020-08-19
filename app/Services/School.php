<?php

namespace App\Services;

class School extends Service
{
    public function detail($schoolId)
    {
        $response = $this->get("/schools/$schoolId");

        return $this->showResponse($response);
    }
}
