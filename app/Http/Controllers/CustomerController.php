<?php

namespace App\Http\Controllers;

use App\Models\BillingDetail;
use App\Models\CustomerLogin;
use App\Models\CustomerPasswordReset;
use App\Models\Order;
use App\Models\OrderedProduct;
use App\Notifications\CustomerPassResetNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules\Password;
use Str;
use Image;
use PDF;

class CustomerController extends Controller
{
    public function customerProfile()
    {
        return view('frontend.customerProfile');
    }

    public function updateCustomerProfile(Request $request)
    {
        if ($request->oldPassword == null) {
            if ($request->profileImage == null) {
                if (Hash::check($request->email, Auth::guard('customerLogin')->user()->email)) {
                    customerLogin::find(Auth::guard('customerLogin')->id())->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'mobile' => $request->mobile,
                        'country' => $request->country,
                        'address' => $request->address
                    ]);
                    return back()->with('updPassSucc', 'Profile updated successfully.');
                } else {
                    if (customerLogin::where('email', '!=', Auth::guard('customerLogin')->user()->email)->where('email', $request->email)->exists()) {
                        return back()->with('emailExists', 'The email already exists.');
                    } else {
                        customerLogin::find(Auth::guard('customerLogin')->id())->update([
                            'name' => $request->name,
                            'email' => $request->email,
                            'mobile' => $request->mobile,
                            'country' => $request->country,
                            'address' => $request->address
                        ]);
                        return back()->with('updPassSucc', 'Profile updated successfully.');
                    }
                }
            } else {
                $request->validate([
                    'profileImage' => 'required|mimes:png,svg,jpg,gif,jfif|max:2048'
                ]);
                $uploadedImg = $request->profileImage;
                $extension = $uploadedImg->getClientOriginalExtension();
                $fileName = Str::lower(str_replace(' ', '-', Auth::guard('customerLogin')->user()->name)) . '-' . rand(100000, 999999) . '.' . $extension;
                Image::make($uploadedImg)->resize(300, 200)->save(public_path('uploads/customer/profileImage/' . $fileName));
                customerLogin::find(Auth::guard('customerLogin')->id())->update([
                    'profileImage' => $fileName,
                    'name' => $request->name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'country' => $request->country,
                    'address' => $request->address
                ]);
                return back()->with('updPassSucc', 'Profile image updated successfully.');
            }
        } else {
            if (Hash::check($request->oldPassword, Auth::guard('customerLogin')->user()->password)) {
                if ($request->profileImage == null) {
                    customerLogin::find(Auth::guard('customerLogin')->id())->update([
                        'password' => bcrypt($request->newPassword),
                        'name' => $request->name,
                        'email' => $request->email,
                        'mobile' => $request->mobile,
                        'country' => $request->country,
                        'address' => $request->address
                    ]);
                } else {
                    $request->validate([
                        'profileImage' => 'required|mimes:png,svg,jpg,gif,jfif|max:2048'
                    ]);
                    $uploadedImg = $request->profileImage;
                    $extension = $uploadedImg->getClientOriginalExtension();
                    $fileName = Str::lower(str_replace(' ', '-', Auth::guard('customerLogin')->user()->name)) . '-' . rand(100000, 999999) . '.' . $extension;
                    Image::make($uploadedImg)->resize(300, 200)->save(public_path('uploads/customer/profileImage/' . $fileName));
                    customerLogin::find(Auth::guard('customerLogin')->id())->update([
                        'password' => bcrypt($request->newPassword),
                        'profileImage' => $fileName,
                        'name' => $request->name,
                        'email' => $request->email,
                        'mobile' => $request->mobile,
                        'country' => $request->country,
                        'address' => $request->address
                    ]);
                }
                return back()->with('updPassSucc', 'Your password updated successfully.');
            } else {
                return back()->with('errorOldPass', 'Old password does not match.');
            }
        }
    }

    // order
    public function myOrder()
    {
        $customerOrder = Order::orderBy('id', 'DESC')->where('customerId', Auth::guard('customerLogin')->id())->get();
        return view('frontend.myOrder', compact('customerOrder'));
    }

    public function orderInvoiceDownload($orderId)
    {
        $orderId = '#' . $orderId;
        $billingInfo = BillingDetail::where('orderId', $orderId)->get()->first();
        $orderProducts = OrderedProduct::where('orderId', $orderId)->get();
        $orderInfo = Order::where('orderId', $orderId)->get()->first();
        $pdf = PDF::loadView('frontend.invoice.orderInvoiceDownload', compact('orderId', 'orderInfo', 'orderProducts', 'billingInfo'));

        // return $pdf->download('orderInvoice.pdf');
        return $pdf->stream('orderInvoice.pdf');
    }

    public function passResetEmail()
    {
        return view('frontend.passwordReset.index');
    }

    public function passResetStore(Request $request)
    {
        if (CustomerLogin::where('email', $request->email)->exists()) {
            $customer = CustomerLogin::where('email', $request->email)->get()->first();
            CustomerPasswordReset::where('customerId', $customer->id)->delete();
            $token = Str::random(64);
            $resetInfo = CustomerPasswordReset::create([
                'customerId' => $customer->id,
                'token' => $token,
                'created_at' => Carbon::now(),

            ]);
            // send password reset notification
            Notification::send($customer, new CustomerPassResetNotification($resetInfo));

            return back()->with('requestResetEmail', 'Please check your email.');
        } else {
            return back()->with('wrongEmail', 'There is no Account in inputing email.');
        }
    }
    public function passResetConfirm($token)
    {
        if (CustomerPasswordReset::where('token', $token)->exists()) {
            $reset = CustomerPasswordReset::where('token', $token)->get()->first();
            // if (!$reset || Carbon::parse($reset->created_at)->addHour(1)->isPast(8500)) {
            return view('frontend.notification.passwordResetConfirm', compact('token'));
            // } else {
            //     return abort('404');
            // }
        } else {
            return abort('404');
        }
    }
    public function passResetConfirmStore(Request $request, $token)
    {
        $request->validate([
            'password' => ['required', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols(), 'confirmed'],
            'password_confirmation' => 'required'
        ]);
        $customerId = CustomerPasswordReset::where('token', $token)->get()->first();
        if (CustomerPasswordReset::where('token', $token)->exists()) {
            CustomerLogin::where('id', $customerId->customerId)->update([
                'password' => Hash::make($request->password),
            ]);
            if ($customerId) {
                CustomerPasswordReset::where('customerId', $customerId->customerId)->delete();
                return back()->with('customerPassResetSucc', 'Password Reset Successfully.');
            }
        } else {
            return abort('404');
        }
    }
}
