<?php

namespace App\Exports\MiniAssessment;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ScoreBystudentGroupExport implements FromView, ShouldAutoSize
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('teacher.mini_assessments.subjects.subject_teachers.study_group_report._export', [
            'data' => $this->data,
        ]);
    }
}
