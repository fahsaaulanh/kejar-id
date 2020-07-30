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
        if (session()->get('changePhotoOnBoarding') === true && $req->photo === null) {
            session()->put('changePhotoOnBoarding', false);

            return redirect()->back();
        }

        $img = Image::make($req->photo);
        $image = (string) $img->stream('data-url');

        $payload = [
            'photo' => $image,
        ];

        $meApi = new MeApi;
        $response = $meApi->update($payload);

        session()->put('changePhotoOnBoarding', false);
        session()->put('user', $response['data']);

        return redirect()->back()->with('message', 'Foto profil berhasil diubah!');
    }
}
