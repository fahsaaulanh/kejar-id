<?php

namespace App\Services;

use Illuminate\Http\Request;

class modalService extends Service {

    public function edit($id)
    {
        $response = $this->get('/matrikulasi/libraries/rounds/' . $id);
        return $this->showResponse($response);
    }

    public function update($data, $id)
    {
        $response = $this->patch('/matrikulasi/libraries/rounds/' . $id, $data);
        return $this->showResponse($response);
    }
    
}
