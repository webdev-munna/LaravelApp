<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Str;
use Image;

class UserController extends Controller
{
    public function admin()
    {
        return view('auth.login');
    }
    public function userList()
    {
        $userList = User::all();
        return view('admin.user.userList', [
            'userList' => $userList,
        ]);
    }
    public function userDelete($userDelete)
    {
        User::find($userDelete)->delete();
        return back()->with('userDel', 'User Deleted Successfully');
    }
    public function profile()
    {
        return view('admin.user.profile');
    }
    public function updateProfile(Request $request)
    {
        User::find(auth::id())->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        return back()->with('proUpd', 'Profile updated successfully.');
    }
    function updatePass(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => ['required', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols(), 'confirmed'],
            'password_confirmation' => 'required'
        ], [
            'old_password.required' => 'Enter your old password.',
        ]);
        if (Hash::check($request->old_password, auth::user()->password)) {
            User::find(auth::id())->update([
                'password' => bcrypt($request->password)
            ]);
        };
        return back()->with('passUpd', 'Password updated successfully');
    }
    public function updateImg(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:png,svg,jpg,gif,jfif|max:2048'
        ]);
        $uploadedImg = $request->image;
        $extension = $uploadedImg->getClientOriginalExtension();
        $fileName = Str::lower(str_replace(' ', '-', auth::user()->name)) . '-' . rand(100000, 999999) . '.' . $extension;
        Image::make($uploadedImg)->resize(300, 200)->save(public_path('uploads/user/' . $fileName));
        User::find(Auth::id())->update([
            'image' => $fileName,
        ]);
        return back();
    }
}
