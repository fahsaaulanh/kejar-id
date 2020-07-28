<?php

namespace App\Http\Controllers;

// User Service
use App\Services\User as UserApi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->has('token') === true) {
            $userApi = new UserApi;
            $responseMe = $userApi->me();
            
            if ($responseMe['data']['role'] === 'STUDENT') {
                return redirect('/student/games');
            }
            
            if ($responseMe['data']['role'] === 'TEACHER') {
                return redirect('/teachers/games');
            }

            if ($responseMe['data']['role'] === 'ADMIN') {
                return redirect('/admin/games');
            }

            if ($responseMe['error']) {
                return redirect('/login');
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

    public function teacher()
    {
        $userApi = new UserApi;
        $response = $userApi->me();

        if ($response['error']) {
            return redirect('/login');
        }

        session(['user' => $response['data']]);

        return view('teacher.games.index', $response['data']);
    }

    public function admin()
    {
        $userApi = new UserApi;
        $response = $userApi->me();

        if ($response['error']) {
            return redirect('/login');
        }

        session(['user' => $response['data']]);

        return view('admin.games.index', $response['data']);
    }

    public function student()
    {
        echo 'Example Student';
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
