<?php

namespace App\Http\Controllers;

use App\Services\User as UserApi;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->has('token')) {
            return redirect('/dashboard');
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

            return redirect('/dashboard');
        }

        $request->session()->flash('message', $response['message']);

        return redirect('/login');
    }
}
