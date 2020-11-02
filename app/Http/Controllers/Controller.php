<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    protected $request;
    protected $reportAccess;

    //
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->reportAccess = $this->teacherAccess();
    }

    private function teacherAccess()
    {
        // teacher given access at 6pm until 6am
        $dateNow = Carbon::now();
        $timeNow = $dateNow->format('H:i');
        $first = Carbon::create($dateNow->year, $dateNow->month, $dateNow->day, 0, 0, 0)->format('H:i');
        $second = Carbon::create($dateNow->year, $dateNow->month, $dateNow->day, 23, 59, 59)->format('H:i');

        if ($timeNow >= $first) {
            return true;
        }

        return $timeNow <= $second;
    }
}
