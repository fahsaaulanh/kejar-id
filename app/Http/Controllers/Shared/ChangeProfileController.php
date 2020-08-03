<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Services\Me as MeApi;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class ChangeProfileController extends Controller
{
    public function update(Request $req)
    {
        $img = Image::make($req->photo);

        // Resize
        $img->resize(100, 100);

        // Base64 encoded stream. Also supports 'jpg', 'png' and more...
        $dataUrl = (string) $img->stream('data-url'); 
        dd($dataUrl);
        $payload = [
            'photo' => $req->photo,
        ];
        
        $meApi = new MeApi;
        $meApi->update($payload);

        return redirect()->back()->with('message', 'Foto profil berhasil diubah!');
    }
}
