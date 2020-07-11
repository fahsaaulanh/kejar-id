<?php

namespace App\Services;

class Task extends Service
{
    public function getAll($game)
    {
        $response = $this->get("/matrikulasi/games/$game/stages");

        return $this->showResponse($response);
    }
}
