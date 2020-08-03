<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->session()->get('user', null);

        if ($user === null) {
            return redirect('/login');
        }

        return view('student.games.index', $user);
    }
}
