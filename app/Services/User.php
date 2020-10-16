<?php

namespace App\Services;

class User extends Service
{

    public function login($username, $password)
    {
        $data = [
            'username' => $username,
            'password' => $password,
        ];

        $response = $this->post('/authentications', $data);

        return $this->showResponse($response);
    }

    public function logout()
    {
        $response = $this->delete('/authentications');

        return $this->showResponse($response);
    }

    public function me()
    {
        $response = $this->get('/me');

        return $this->showResponse($response);
    }

    public function meTask($filter)
    {
        $response = $this->get('/me/tasks', $filter);

        return $this->showResponse($response);
    }

    public function students($filter)
    {
        $response = $this->get('/users/students', $filter);

        return $this->showResponse($response);
    }

    public function detailTeacher($id)
    {
        $response = $this->get('/users/teachers/'.$id);

        return $this->showResponse($response);
    }
}
