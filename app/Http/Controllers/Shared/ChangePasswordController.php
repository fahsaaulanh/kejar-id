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

        //chek password sama dengan username
        if ($request->password_baru === session()->get('user.username')) {
            return redirect()->back()->withErrors(
                ['password_baru' => 'Password baru tidak boleh sama dengan username.'],
            )->withInput(['password_baru' => $request->password_baru]);
        }
        
        $meApi = new MeApi;
        $result = $meApi->update($payload);
        
        if ($result['status'] === 200) {
            //update session password sudah diperbarui
            $request->session()->put('user.PasswordMustBeChanged', false);
            
            $checkPhoto = session()->get('user.userable.photo');

            if (!$checkPhoto) {
                $request->session()->put('user.changePhotoOnBoarding', true);
            }
    
            Session::flash('message', 'Ubah password berhasil!');
        } else {
            $error = '';
            foreach ($result['errors'] as $key => $v) {
                if ($key !== 0) {
                    $error .= ',';
                }

                $error .= $v['message'];
            }

            Session::flash('message', 'Ubah password gagal! '.$error);
        }

        return redirect()->back();
    }

    public function skip()
    {
        if (request()->type === 'password') {
            $checkPhoto = session()->get('user.userable.photo');
            
            if (!$checkPhoto) {
                request()->session()->put('user.changePhotoOnBoarding', true);
            }

            request()->session()->put('user.PasswordMustBeChanged', false);
        } elseif (request()->type === 'photo') {
            request()->session()->put('user.changePhotoOnBoarding', false);
        }

        return redirect()->back();
    }
}
