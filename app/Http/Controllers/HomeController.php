<?php

namespace App\Http\Controllers;

// User Service
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PDF;

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

        return view('teacher.games.index', $user);
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

    public function print()
    {
        $date = Carbon::now()->translatedFormat('d F Y');

        $time = Carbon::now()->translatedFormat('H:i');

        $pdf = PDF::loadview('student.mini_assessment.exam.answer', ['date' => $date, 'time' => $time])
            ->setPaper('a4', 'potrait');

        return $pdf->donwload();
    }
}
