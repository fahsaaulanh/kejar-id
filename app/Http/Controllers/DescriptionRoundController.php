<?php

namespace App\Http\Controllers;

// User Service
use App\Services\Round as RondeApi;

class DescriptionRoundController extends Controller
{
    public function index($roundId)
    {
        $roundApi = new RondeApi;
        $round = $roundApi->getDetail($roundId)['data'] ?? [];
        
        return view('teacher/rounds/index', compact('round'));
    }
}
