<?php

namespace App\Services;

class Me extends Service
{
    public function update($payload)
    {
        $response = $this->patch('/me', $payload);
        
        return $this->showResponse($response);
    }

    public function me()
    {
        $response = $this->get('/me');
        
        return $this->showResponse($response);
    }
}
