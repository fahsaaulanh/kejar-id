<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    public function update(Request $request)
    {
        $this->validate($request, [
            'password_baru' => 'required|min:6|confirmed',
        ]);
        
        dd($request->all());
    }
}
