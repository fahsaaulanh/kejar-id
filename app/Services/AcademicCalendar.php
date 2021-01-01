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
}
