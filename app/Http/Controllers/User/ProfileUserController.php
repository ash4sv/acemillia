<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ImageUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileUserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function profileEdit()
    {
        return response()->view('apps.user.profile.profile', [
            'authUser' => auth()->guard('web')->user(),
            'genders' => $this->genders,
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
            'img_avatar' => $imageFilePath,
            'identification_number' => $request->input('identification_number'),
        ]);

        Alert::success('Successfully Update!', 'Profile has been updated!');
        return redirect()->back();
    }

    public function passwordEdit()
    {
        return response()->view('apps.user.profile.password');
    }

    public function passwordUpdate(Request $request)
    {
        // Validate the inputs
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|confirmed',
        ]);

        // Retrieve the authenticated user
        $user = auth()->guard('web')->user();

        // Check if the provided current password matches the one stored
        if (!Hash::check($request->current_password, $user->password)) {
            Alert::error('Error', 'Current password is incorrect.');
            return redirect()->back();
        }

        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();

        Alert::success('Success', 'Password updated successfully.');
        return redirect()->back();
    }

}
