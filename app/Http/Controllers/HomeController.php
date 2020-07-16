<?php

namespace App\Http\Controllers;

// User Service
use App\Services\User as UserApi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->has('token')) {
            $userApi = new UserApi;
            $responseMe = $userApi->me();

            if ($responseMe['data']['role'] === 'STUDENT') {
                return redirect('/students/games');
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
        echo 'Dashboard';
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
