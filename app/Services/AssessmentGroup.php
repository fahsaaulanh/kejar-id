<?php

namespace App\Services;

class AssessmentGroup extends Service
{
    public function index($filter = [])
    {
        $response = $this->get('/commons/assessment-groups', $filter);

        return $this->showResponse($response);
    }

    public function detail($assessmentGroupId)
    {
        $response = $this->get("/commons/assessment-groups/$assessmentGroupId");

        return $this->showResponse($response);
    }

    public function create($payload)
    {
        $response = $this->post('/commons/assessment-groups', $payload);

        return $this->showResponse($response);
    }

    public function update($assessmentGroupId, $payload)
    {
        $response = $this->patch("/commons/assessment-groups/$assessmentGroupId", $payload);

        return $this->showResponse($response);
    }
}
