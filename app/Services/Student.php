<?php

namespace App\Services;

class Student extends Service
{

    public function update($studentId, $data)
    {
        $response = $this->patch("/users/students/$studentId", $data);
        return $this->showResponse($response);
    }
}
