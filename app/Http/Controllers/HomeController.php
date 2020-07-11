<?php

namespace App\Http\Controllers;

// User Service
use App\Services\User as UserApi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'message' => '',
        ];

        return view('login/index', $data);
    }

    public function dashboard()
    {
        $userApi = new UserApi;
        $response = $userApi->me();

        if ($response['error']) {
            return redirect('/login');
        }

        session(['user' => $response['data']]);

        return view('home/dashboard', $response['data']);
    }

    public function teacher()
    {
        echo 'Example Teacher';
    }

    public function admin()
    {
        echo 'Example Admin';
    }

    public function student()
    {
        echo 'Example Student';
    }

    public function logout(Request $request)
    {
        $userApi = new UserApi;
        $response = $userApi->me();

        if (!$response['error']) {
            $request->session()->flush();
        }

        return redirect('/login');
    }
}
