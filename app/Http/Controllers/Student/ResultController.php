<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

class ResultController extends Controller
{
    public function index()
    {
        $score = 85;

        // TODO API SCORE RESULT

        return view('result.index', compact('score'));
    }
}
