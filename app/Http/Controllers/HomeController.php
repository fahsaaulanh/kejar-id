<?php

namespace App\Http\Controllers;

// User Service

use App\Services\AcademicCalendar;
use App\Services\AssessmentGroup;
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
        $academicCalendar = new AcademicCalendar;
        $academicYear = $academicCalendar->currentAcademicYear(true);

        if ($user === null) {
            return redirect('/login');
        }

        $wikramaId = [
            // staging
            '73ceaf53-a9d8-4777-92fe-39cb55b6fe3b', // bogor
            '35fd6bcd-2df7-414d-b7e2-20b62490d561', // garut

            // prod
            '3da67e44-ca12-4ae8-b784-f066ea605887', // bogor
            '6286566b-a2ce-4649-9c0c-078c434215af', // garut
        ];

        return view('teacher.dashboard.index')
               ->with('user', $user)
               ->with('wikramaId', $wikramaId)
            //    ->with('miniAssesmentGroup', $miniAssesmentGroup)
               ->with('reportAccess', $this->reportAccess)
               ->with('academicYear', $academicYear);
    }

    public function student(Request $request)
    {
        $user = $request->session()->get('user', null);
        $academicCalendar = new AcademicCalendar;
        $academicYear = $academicCalendar->currentAcademicYear(true);

        if ($user === null) {
            return redirect('/login');
        }

        return view('student.games.index')
                ->with('user', $user)
                ->with('academicYear', $academicYear);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect('/login');
    }

    public function getAssessmentGroups()
    {
        $assessmentGroupApi = new AssessmentGroup;
        $academicCalendar = new AcademicCalendar;
        $user = $this->request->session()->get('user', null);

        $filter = [
            'filter[school_year]' => $academicCalendar->currentAcademicYear(),
            'filter[school_id]' => $user['userable']['school_id'],
        ];

        return $assessmentGroupApi->index($filter);
    }

    public function createAssessmentGroup()
    {
        $assessmentGroupApi = new AssessmentGroup;
        $academicCalendar = new AcademicCalendar;

        $user = $this->request->session()->get('user', null);
        $title = $this->request->input('title', null);

        $payload = [
            'title' => $title,
            'school_id' => $user['userable']['school_id'],
            'school_year' => $academicCalendar->currentAcademicYear(),
        ];

        return $assessmentGroupApi->create($payload);
    }
}
