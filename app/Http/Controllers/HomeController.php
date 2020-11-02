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

            if ($user['role'] === 'TEACHER') {
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

        $miniAssesmentGroup = [
            'PTS-semester-ganjil-2020-2021' => 'PTS Semester Ganjil 2020-2021',
            'PTS-susulan-semester-ganjil-2020-2021' => 'PTS Susulan Semester Ganjil 2020-2021',
        ];

        return view('admin.games.index', $user)->with('user', $user)->with('miniAssesmentGroup', $miniAssesmentGroup);
    }

    public function teacher(Request $request)
    {
        $user = $request->session()->get('user', null);

        if ($user === null) {
            return redirect('/login');
        }

        $miniAssesmentGroup = [
            'PTS-semester-ganjil-2020-2021' => 'PTS Semester Ganjil 2020-2021',
            'PTS-susulan-semester-ganjil-2020-2021' => 'PTS Susulan Semester Ganjil 2020-2021',
        ];

        $wikramaId = [
            // staging
            '73ceaf53-a9d8-4777-92fe-39cb55b6fe3b', // bogor
            '35fd6bcd-2df7-414d-b7e2-20b62490d561', // garut

            // prod
            '3da67e44-ca12-4ae8-b784-f066ea605887', // bogor
            '6286566b-a2ce-4649-9c0c-078c434215af', // garut
        ];

        return view('teacher.games.index')
               ->with('user', $user)
               ->with('wikramaId', $wikramaId)
               ->with('miniAssesmentGroup', $miniAssesmentGroup)
               ->with('reportAccess', $this->reportAccess);
    }

    public function student(Request $request)
    {
        $user = $request->session()->get('user', null);

        if ($user === null) {
            return redirect('/login');
        }

        return view('student.games.index', $user);
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

    public function modal()
    {
        return view('admin.questions.soalcerita.create._mengurutkan');
    }
}
