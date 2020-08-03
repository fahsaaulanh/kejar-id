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
        if($request->password_baru == session()->get('user.username')){
            Session::flash('message', 'Ubah password gagal!, password tidak boleh dengan username');
            return redirect()->back();
        }
        
        $meApi = new MeApi;
        $result = $meApi->update($payload);
        
        if($result['status'] == 200){
            //update session password sudah diperbarui
            $request->session()->put('checkPasswordDefault', FALSE);
    
            Session::flash('message', 'Ubah password berhasil!');
        }else{    
            $error = "";
            foreach($result['errors'] as $key => $v){
                if($key != 0){
                    $error .= ",";
                }
                $error .= $v['message'];
            }

            Session::flash('message', 'Ubah password gagal! '.$error);
        }

        return redirect()->back();
    }

    public function skip()
    {
        session()->put('PasswordMustBeChanged', FALSE);
        return redirect()->back();
    }
}
