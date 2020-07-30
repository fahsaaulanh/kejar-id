<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Services\Me as MeApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ChangePasswordController extends Controller
{
    public function update(Request $request)
    {
        $this->validate($request, [
            'password_baru' => 'required|min:6',
            'konfirmasi_password' => 'required|min:6',
        ]);

        $confirm = $request->konfirmasi_password;

        if ($request->password_baru !== $confirm) {
            return redirect()->back()
                            ->withErrors(['konfirmasi_password' => 'Konfirmasi password baru tidak cocok.'])
                            ->withInput();
        }

        $payload = [
            'password' => $request->password_baru,
        ];
        
        $meApi = new MeApi;
        $meApi->update($payload);

        Session::flash('message', 'Ubah password berhasil!');

        return redirect()->back();
    }
}
