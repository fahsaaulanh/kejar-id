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
            $message = $request->session()->get('message', null);

            if ($user === null) {
                return redirect('/login');
            }

            if ($user['role'] === 'STUDENT') {
                return redirect('/student/games')->with('message', $message);
            }

            if ($user['role'] === 'TEACHER') {
                return redirect('/teacher/games')->with('message', $message);
            }

            if ($user['role'] === 'ADMIN') {
                return redirect('/admin/games')->with('message', $message);
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
                //check password sudah diganti

                // $response = $userApi->login($responseMe['data']['username'], $responseMe['data']['username']);
                // if ($response['status'] === 200) {
                //     session(['PasswordMustBeChanged' => true]);
                // } else {
                //     session(['PasswordMustBeChanged' => false]);
                // }

                return redirect('/student/games');
            }

            if ($responseMe['data']['role'] === 'TEACHER') {
                // check password

                // $response = $userApi->login($responseMe['data']['username'], $responseMe['data']['username']);
                // if ($response['status'] === 200) {
                //     session(['PasswordMustBeChanged' => true]);
                // } else {
                //     session(['PasswordMustBeChanged' => false]);
                // }

                // session('user.userable.photo') === null ?
                //     session(['changePhotoOnBoarding' => true]) :
                //     session(['changePhotoOnBoarding' => false]);

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
