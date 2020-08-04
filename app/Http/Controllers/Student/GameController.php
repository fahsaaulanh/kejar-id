<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\User as UserApi;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $userApi = new UserApi;
        $response = $userApi->me();
        
        $user = $request->session()->get('user', null);

        if ($user === null) {
            return redirect('/login');
        }

        session(['user' => $response['data']]);

        return view('student.games.index', ['data'=>$response['data']]);
    }

    public function dashboard()
    {
        return redirect('student/game');
    }
}
