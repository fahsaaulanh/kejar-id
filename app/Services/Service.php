<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Service {
    protected $token;

    public function __construct(){
        $this->token = session('token', null);
    }

    public function get($url, $queryParams = []) {
        return Http::withToken($this->token)->get(env('API_HOST').$url, $queryParams);
    }

    public function post($url, $data = []) {
        return Http::withToken($this->token)->post(env('API_HOST').$url, $data);
    }

    public function put($url, $data = []) {
        return Http::withToken($this->token)->put(env('API_HOST').$url, $data);
    }

    public function patch($url, $data = []) {
        return Http::withToken($this->token)->patch(env('API_HOST').$url, $data);
    }

    public function delete($url, $data = []) {
        return Http::withToken($this->token)->delete(env('API_HOST').$url, $data);
    }

    public function showResponse(Response $response) {
        $body = $response->json();
        if ($response->failed()) {
            return [
                'status' => $response->status(),
                'error' => true,
                'message' => $body['message'],
                'errors' => $body['errors'],
            ];
        }

        return [
            'status' => $response->status(),
            'error' => false,
            'data' => $body['data'] ? $body['data'] : null,
        ];
    }
}
