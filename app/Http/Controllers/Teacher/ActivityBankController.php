<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityBankController extends Controller
{
    //
    public function review(){
        return view('teacher.ActivityBank.review.index');
    }
    public function ulasan(){
        return view('teacher.ActivityBank.review.indexx');
    }
}
