<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function coupon()
    {
        $coupons = Coupon::all();
        return view('admin.coupon.coupon', [
            'coupon' => $coupons,
        ]);
    }
    public function couponStore(Request $request)
    {
        $request->validate([
            'couponName' => 'required',
            'type' => 'required',
            'couponDiscount' => 'required',
            'minimum' => 'required',
            'maximum' => 'required',
            'validity' => 'required',
        ]);
        Coupon::insert([
            'couponName' => $request->couponName,
            'type' => $request->type,
            'couponDiscount' => $request->couponDiscount,
            'minimum' => $request->minimum,
            'maximum' => $request->maximum,
            'validity' => $request->validity
        ]);
        return back()->with('couponIns', 'Coupon Inserted Successfully.');
    }
    public function couponEdit($couponId)
    {
        $couponInfo = Coupon::find($couponId);
        return view('admin.coupon.couponEdit', [
            'couponInfos' => $couponInfo,
        ]);
    }
    public function couponUpdate(Request $request)
    {
        Coupon::find($request->couponId)->update([
            'couponName' => $request->couponName,
            'type' => $request->type,
            'couponDiscount' => $request->discount,
            'minimum' => $request->minimum,
            'maximum' => $request->maximum,
            'validity' => $request->validity,
        ]);
        return back()->with('couponUpdate', 'Coupon updated successfully.');
    }
    public function couponDelete($couponId)
    {
        Coupon::find($couponId)->delete();
        return back()->with('deleteCpn', 'Coupon deleted successfully.');
    }
}
