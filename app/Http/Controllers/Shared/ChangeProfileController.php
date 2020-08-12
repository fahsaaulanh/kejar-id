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
        $pc = session()->get('user.changePhotoOnBoarding');
        if ((is_null($req->photo) && $pc === false) || (is_null($req->photo_onboarding) && $pc === true)) {
            return redirect()->back();
        }

        $photo = !is_null($req->photo) ? $req->photo : $req->photo_onboarding;
        $img = Image::make($photo);
        $image = (string) $img->stream('data-url');
        
        $payload = [
            'photo' => $image,
        ];

        $meApi = new MeApi;
        $response = $meApi->update($payload);

        session()->put('user.userable.photo', $response['data']['userable']['photo']);
        session()->put('user.photoExistCheck', true);
        session()->put('user.changePhotoOnBoarding', false);

        return redirect()->back()->with('profile_updated', 'Foto profil berhasil diubah!');
    }
}
