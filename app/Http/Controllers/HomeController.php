<?php

namespace App\Http\Controllers;

// User Service
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->has('token') === true) {
            $user = $request->session()->get('user', null);

            if ($user === null) {
                return redirect('/login');
            }

            if ($user['role'] === 'STUDENT') {
                return redirect('/student/games');
            }

            if ($user['role'] === 'ADMIN') {
                return redirect('/admin/games');
            }

            if ($user['teacher'] === 'TEACHER') {
                return redirect('/teacher/games');
            }
        }

        $data = [
            'message' => '',
        ];

        return view('login/index', $data);
    }

    public function dashboard()
    {
        $user = session('user');

        return view('home.dashboard', $user);
    }

    public function admin(Request $request)
    {
        $user = $request->session()->get('user', null);

        if ($user === null) {
            return redirect('/login');
        }

        return view('admin.games.index', $user);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect('/login');
    }

    public function example()
    {
        return view('example.withHeader');
    }
}
