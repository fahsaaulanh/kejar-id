<?php

namespace App\Services;

use Illuminate\Http\Request;

class Task extends Service {

    public function getAll($game){
        $response = $this->get("/matrikulasi/games/$game/stages");
        return $this->showResponse($response);
    }
    
}
