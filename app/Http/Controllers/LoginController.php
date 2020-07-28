<?php

namespace App\Http\Controllers;

use App\Services\User as UserApi;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->has('token')) {
            $userApi = new UserApi;
            $responseMe = $userApi->me();

            if ($responseMe['data']['role'] === 'STUDENT') {
                return redirect('/student/games');
            }

            if ($responseMe['data']['role'] === 'TEACHER') {
                return redirect('/teacher/games');
            }

            if ($responseMe['data']['role'] === 'ADMIN') {
                return redirect('/admin/games');
            }

            if ($responseMe['error']) {
                return redirect('/login');
            }
        }

        $data = [
            'message' => $request->session()->get('message'),
        ];

        return view('login/index', $data);
    }

    public function login(Request $request)
    {
        $data = $request->only(['username', 'password']);
        $userApi = new UserApi;
        $response = $userApi->login($data['username'], $data['password']);

        if (!$response['error']) {
            session(['token' => $response['data']['token']]);

            $userApiMe = new UserApi;
            $responseMe = $userApiMe->me();


            $request->session()->put('user', $responseMe['data']);

            if ($responseMe['data']['role'] === 'STUDENT') {
                return redirect('/student/games');
            }

            if ($responseMe['data']['role'] === 'TEACHER') {
                return redirect('/teacher/games');
            }

            if ($responseMe['data']['role'] === 'ADMIN') {
                return redirect('/admin/games');
            }
        }

        $request->session()->flash('message', $response['message']);

        return redirect('/login');
    }
}
