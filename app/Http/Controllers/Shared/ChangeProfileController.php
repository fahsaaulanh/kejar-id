<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Services\Me as MeApi;
use Illuminate\Http\Request;

class ChangeProfileController extends Controller
{
    public function update(Request $req)
    {
        // $img = Image::make($req->photo);
        // $img->save('example.png', 20);
        // $image = $img->encode('jpg', 0);
        // $dataUrl = (string) $image->stream('data-url');
        $payload = [
            'photo' => $req->photo,
        ];
        
        $meApi = new MeApi;
        $meApi->update($payload);

        return redirect()->back()->with('message', 'Foto profil berhasil diubah!');
    }
}
