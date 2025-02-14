<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ImageUploader;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileUserController extends Controller
{
    public function profileEdit()
    {
        return response()->view('apps.user.profile.profile', [
            'authUser' => auth()->guard('web')->user()
        ]);
    }

    public function profileUpdate(Request $request)
    {
        $user = auth()->guard('web')->user();
        $phoneNo = preg_replace('/[^0-9]/', '', $request->input('phone'));
        $registerName = strtoupper($request->input('name'));
        $char = $registerName[0] ?? '';

        $imageFilePath = $request->file('avatar')
            ? ImageUploader::uploadSingleImage($request->file('avatar'), 'assets/upload/', $user->name . '_image')
            : ($user->img_avatar ?? null);

        $user->update([
            'name' => $registerName,
            'phone' => $phoneNo,
            'icon_avatar' => $char,
            'img_avatar' => $imageFilePath
        ]);
        Alert::success('Successfully Update!', 'Profile has been updated!');
        return redirect()->back();
    }

    public function passwordEdit()
    {
        return response()->view('apps.user.profile.password');
    }
}
