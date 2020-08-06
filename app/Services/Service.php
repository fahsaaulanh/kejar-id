<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Service
{
    protected $token;
    private $timeout = 15;

    public function __construct()
    {
        $this->token = session('token', null);
    }

    public function get($url, $queryParams = [])
    {
        try {
            return Http::withToken($this->token)->timeout($this->timeout)->get(env('API_HOST').$url, $queryParams);
        } catch (Exception $error) {
            abort(408, 'Connection Timeout.');
        }
    }

    public function post($url, $data = [])
    {
        try {
            return Http::withToken($this->token)->timeout($this->timeout)->post(env('API_HOST').$url, $data);
        } catch (Exception $error) {
            abort(408, 'Connection Timeout.');
        }
    }

    public function put($url, $data = [])
    {
        try {
            return Http::withToken($this->token)->timeout($this->timeout)->put(env('API_HOST').$url, $data);
        } catch (Exception $error) {
            abort(408, 'Connection Timeout.');
        }
    }

    public function patch($url, $data = [])
    {
        try {
            return Http::withToken($this->token)->timeout($this->timeout)->patch(env('API_HOST').$url, $data);
        } catch (Exception $error) {
            abort(408, 'Connection Timeout.');
        }
    }

    public function delete($url, $data = [])
    {
        try {
            return Http::withToken($this->token)->timeout($this->timeout)->delete(env('API_HOST').$url, $data);
        } catch (Exception $error) {
            abort(408, 'Connection Timeout.');
        }
    }

    public function showResponse(Response $response)
    {
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
            'data' => $body['data'] ?: null,
            'meta' => $body['meta'] ?? null,
        ];
    }
}
