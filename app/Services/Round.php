<?php

namespace App\Services;

class Round extends Service
{

    public function index($filter = '')
    {
        $response = $this->get('/matrikulasi/libraries/rounds'. $filter);

        return $this->showResponse($response);
    }

    public function store($data)
    {
        $response = $this->post('/matrikulasi/libraries/rounds', $data);

        return $this->showResponse($response);
    }

    public function getDetail($roundId)
    {
        $response = $this->get("/matrikulasi/libraries/rounds/$roundId");

        return $this->showResponse($response);
    }

    public function update($data, $id)
    {
        $response = $this->patch('/matrikulasi/libraries/rounds/' . $id, $data);

        return $this->showResponse($response);
    }
}
