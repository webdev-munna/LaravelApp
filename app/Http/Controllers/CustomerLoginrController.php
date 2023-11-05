<?php

namespace App\Http\Controllers;

use App\Models\CustomerLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class CustomerLoginrController extends Controller
{
    function loginCustomer(Request $request)
    {
        if (Auth::guard('customerLogin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Auth::guard('customerLogin')->user()->email_verify_at == null) {
                Auth::guard('customerLogin')->logout();
                return back()->with('errorLogin', 'Please Verify Your Email First.');
            } else {
                return redirect('/');
            }
        } else {
            return back()->with('errorLogin', 'Wrong email or password!');
        }
    }
    function customerLogout()
    {
        Auth::guard('customerLogin')->logout();
        return redirect()->route('registerLogin');
    }

    // Socialite login by Github
    function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }
    public function handleGithubCallback()
    {

        $user = Socialite::driver('github')->user();

        $finduser = CustomerLogin::where('github_id', $user->id)->first();

        if ($finduser) {

            Auth::guard('customerLogin')->login($finduser);

            return redirect(route('frontHome'));
        } else {
            $newUser = CustomerLogin::updateOrCreate(
                ['email' => $user->email],
                [
                    'name' => $user->name,
                    'github_id' => $user->id,
                    'password' => encrypt('123456dummy')
                ]
            );

            Auth::guard('customerLogin')->login($newUser);

            return redirect(route('frontHome'));
        }
    }
    // login by Github end

    // login by Google
    function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {

        $user = Socialite::driver('google')->user();

        // method 1
        if (CustomerLogin::where('email', $user->getEmail)->exists()) {
            if (Auth::guard('customerLogin')->attempt(['email' => $user->getEmail(), 'password' => 'google123'])) {
                return redirect('/');
            }
        }
        CustomerLogin::insert([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => bcrypt('google123'),
        ]);
        if (Auth::guard('customerLogin')->attempt(['email' => $user->getEmail(), 'password' => 'google123'])) {
            return redirect('/');
        } else {
            return redirect(route('registerLogin'));
        }

        // method 2
        // $finduser = CustomerLogin::where('google_id', $user->id)->first();

        // if ($finduser) {

        //     Auth::guard('customerLogin')->login($finduser);

        //     return redirect(route('frontHome'));
        // } else {
        //     $newUser = CustomerLogin::updateOrCreate(
        //         ['email' => $user->email],
        //         [
        //             'name' => $user->name,
        //             'google_id' => $user->id,
        //             'password' => encrypt('123google')
        //         ]
        //     );

        //     Auth::guard('customerLogin')->login($newUser);

        //     return redirect(route('frontHome'));
        // }
    }
    // login by Google end
}
