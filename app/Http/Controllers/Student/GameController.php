<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\User as UserApi;

class GameController extends Controller
{
    public function index()
    {
        $userApi = new UserApi;
        $response = $userApi->me();

        if ($response['error']) {
            return redirect('/login');
        }

        session(['user' => $response['data']]);

        return view('student.games.index', $response['data']);
    }
}
