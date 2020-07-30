<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Services\Me as MeApi;
use Illuminate\Http\Request;

class ChangeProfileController extends Controller
{
    public function update(Request $req)
    {
        $payload = [
            'photo' => $req->photo,
        ];
        
        $meApi = new MeApi;
        $meApi->update($payload);

        return redirect()->back()->with('message', 'Foto profil berhasil diubah!');
    }
}
