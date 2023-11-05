<?php

namespace App\Http\Controllers;

use App\Models\CustomerEmailVerify;
use App\Models\CustomerLogin;
use App\Notifications\CustomerEmailVerifyNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Str;

class CustomerRegisterController extends Controller
{
    public function customerRegister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols(), 'confirmed'],
            'password_confirmation' => 'required'
        ]);
        $customer = CustomerLogin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_at' => Carbon::now(),
        ]);
        $emailVerify = CustomerEmailVerify::create([
            'customerId' => $customer->id,
            'token' => Str::random(64),
            'created_at' => Carbon::now(),
        ]);
        // email verify notification
        Notification::send($customer, new CustomerEmailVerifyNotification($emailVerify));

        // if (Auth::guard('customerLogin')->attempt(['email' => $request->email, 'password' => $request->password])) {
        //     return redirect()->route('frontHome');

        return back()->with('customerReg', 'Please check your email to verify your account.');
    }
    public function confirmEmail($token)
    {
        if (CustomerEmailVerify::where('token', $token)) {
            $customer = CustomerEmailVerify::where('token', $token)->firstOrFail();
            CustomerLogin::where('id', $customer->customerId)->update([
                'email_verify_at' => Carbon::now(),
            ]);
            CustomerEmailVerify::where('token', $token)->delete();
            return redirect()->route('registerLogin');
        } else {
            abort('404');
        }
    }
}
