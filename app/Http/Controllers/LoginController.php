<?php

namespace App\Http\Controllers;

use App\Services\User as UserApi;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->has('token')) {
            $user = $request->session()->get('user', null);

            if ($user === null) {
                return redirect('/login');
            }

            if ($user['role'] === 'STUDENT') {
                return redirect('/student/games');
            }

            if ($user['role'] === 'TEACHER') {
                return redirect('/teacher/games');
            }

            if ($user['role'] === 'ADMIN') {
                return redirect('/admin/games');
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
            $request->session()->put('token', $response['data']['token']);

            $userApi = new UserApi;
            $responseMe = $userApi->me();

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

            if ($responseMe['data']['role'] === 'TEACHER') {
                return redirect('/teacher/games');
            }
        }

        $request->session()->flash('message', $response['message']);

        return redirect('/login');
    }
}
