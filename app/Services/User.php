<?php

namespace App\Services;

use Illuminate\Http\Request;

class User extends Service {

    public function login($username, $password) {
        $data = [
            'username' => $username,
            'password' => $password
        ];

        $response = $this->post('/authentications', $data);
        return $this->showResponse($response);
    }

    public function logout() {
        $response = $this->delete('/authentications');
        return $this->showResponse($response);
    }

    public function me() {
        $response = $this->get('/me');
        return $this->showResponse($response);
    }
}
