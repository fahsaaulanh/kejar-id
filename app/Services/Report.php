<?php

namespace App\Services;

class Report extends Service
{

    public function roundReport($studentGroupId, $stageId, $page = 1)
    {
        $response = $this
            ->get("/reports/matrikulasi/student-groups/$studentGroupId/stages/$stageId", "page=$page&per_page=15");

        return $this->showResponse($response);
    }

    public function stageReport($studentGroupId, $filter = [])
    {
        $response = $this->get("/reports/matrikulasi/student-groups/$studentGroupId/stages", $filter);

        return $this->showResponse($response);
    }

    public function reportAssessment($filter = [])
    {
        $response = $this->get('/reports/assessments/', $filter);

        return $this->showResponse($response);
    }
}
