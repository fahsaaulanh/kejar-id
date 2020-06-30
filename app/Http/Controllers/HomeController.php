<?php

namespace App\Http\Controllers;

// User Service
use Illuminate\Http\Request;
use App\Services\User as UserApi;

class HomeController extends Controller
{
    public function index(Request $request) {
        $userApi = new UserApi();
        $response = $userApi->me();

        if($response['error']) {
            return redirect('/login');
        }

        session(['user' => $response['data']]);

        return view('home/index');
    }

    public function teacher(Request $request) {
        echo 'Example Teacher';
    }

    public function admin(Request $request) {
        echo 'Example Admin';
    }

    public function student(Request $request) {
        echo 'Example Student';
    }

    public function logout(Request $request) {
        $userApi = new UserApi();
        $response = $userApi->me();

        if(!$response['error']) {
            $request->session()->flush();
        }

        return redirect('/login');
    }
}
