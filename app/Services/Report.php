<?php

namespace App\Services;

class Report extends Service
{
    
    public function roundReport($studentGroupId, $stageId, $page = 1)
    {
        $response = $this->get("/reports/matrikulasi/student-groups/$studentGroupId/stages/$stageId", "page=$page");

        return $this->showResponse($response);
    }

    public function stageReport($studentGroupId, $filter = [])
    {
        $response = $this->get("/reports/matrikulasi/student-groups/$studentGroupId/stages", $filter);

        return $this->showResponse($response);
    }
}
