<?php

namespace App\Services;

use Carbon\Carbon;

class AcademicCalendar
{
    public function currentAcademicYear($useDash = false)
    {
        $current = Carbon::now()->format('Y');
        $next = Carbon::now()->addYears(1)->format('Y');

        if ($this->shouldNotChangeYear()) {
            $current = Carbon::now()->subYears(1)->format('Y');
            $next = Carbon::now()->format('Y');
        }

        $value = "$current/$next";

        if ($useDash) {
            $value = str_replace('/', '-', $value);
        }

        return $value;
    }

    public function nextAcademicYear($useDash = false)
    {
        $current = Carbon::now()->addYears(1)->format('Y');
        $next = Carbon::now()->addYears(2)->format('Y');

        if ($this->shouldNotChangeYear()) {
            $current = Carbon::now()->format('Y');
            $next = Carbon::now()->addYears(1)->format('Y');
        }

        $value = "$current/$next";

        if ($useDash) {
            $value = str_replace('/', '-', $value);
        }

        return $value;
    }

    private function shouldNotChangeYear()
    {
        return (int) Carbon::now()->format('m') <= Carbon::JULY
        && (int) Carbon::now()->format('d') < 19;
    }

    public function academicYearByGrade($grade)
    {
        $yearNow = Carbon::now()->year;
        $monthNow = Carbon::now()->month;
        $dayNow = Carbon::now()->day;

        if ($monthNow <= 7 && $dayNow < 19) {
            $yearNow -= 1;
        }

        $year = [
            '10' => $yearNow . '/' . ($yearNow + 1),
            '11' => ($yearNow - 1) . '/' . $yearNow,
            '12' => ($yearNow - 2) . '/' . ($yearNow - 1),
        ];

        return $year[$grade];
    }
}
