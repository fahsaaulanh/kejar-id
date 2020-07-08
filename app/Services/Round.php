<?php

namespace App\Services;

use Illuminate\Http\Request;

class Round extends Service {

    public function index()
    {
        $response = $this->get('/matrikulasi/libraries/rounds');
        return $this->showResponse($response);
    }

    public function store($data)
    {
    	$response = $this->post('/matrikulasi/libraries/rounds', $data);
        return $this->showResponse($response);
    }

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
