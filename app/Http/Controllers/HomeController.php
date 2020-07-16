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
                return redirect('/students/games');
            }

            if ($responseMe['data']['role'] === 'ADMIN') {
                return redirect('/admin');
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
        echo 'Example Teacher';
    }

    public function admin()
    {
        return view('home.dashboard');
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
}
