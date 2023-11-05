<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function cartStore(Request $request)
    {
        if (Auth::guard('customerLogin')->check()) {
            if ($request->submitBtn == '1') {
                if (Cart::where('customerId', Auth::guard('customerLogin')->id())->where('productId', $request->productId)->where('colorId', $request->colorId)->where('sizeId', $request->sizeId)->exists()) {
                    $request->validate([
                        'colorId' => 'required',
                        'sizeId' => 'required',
                        'quantity' => 'required',
                    ], [
                        'colorId.required' => 'Please Select A Color.',
                        'sizeId.required' => 'Please Select A Size.',
                    ]);
                    Cart::where('productId', $request->productId)->where('colorId', $request->colorId)->where('sizeId', $request->sizeId)->increment('quantity', $request->quantity);
                    return back()->with('cartInsert', 'Added to cart successfully.');
                } else {
                    if ($request->colorId == '') {
                        $cId = 1;
                    } else {
                        $cId = $request->colorId;
                    }
                    if ($request->sizeId == '') {
                        $sId = 1;
                    } else {
                        $sId = $request->sizeId;
                    }
                    $request->validate([
                        'colorId' => 'required',
                        'sizeId' => 'required',
                        'quantity' => 'required',
                    ], [
                        'colorId.required' => 'Please Select A Color.',
                        'sizeId.required' => 'Please Select A Size.',
                        'quantity.required' => 'Please Add Quantity For This Product.',
                    ]);
                    Cart::insert([
                        'customerId' => Auth::guard('customerLogin')->id(),
                        'productId' => $request->productId,
                        'colorId' => $cId,
                        'sizeId' => $sId,
                        'quantity' => $request->quantity,
                        'created_at' => Carbon::now(),
                    ]);
                    return back()->with('cartInsert', 'Added to cart successfully.');
                }
            } else {
                if (Wishlist::where('customerId', Auth::guard('customerLogin')->id())->where('productId', $request->productId)->exists()) {
                    return back()->with('wishlistexist', 'This product alrealy exists to wishlist.');
                } else {
                    if ($request->colorId == '') {
                        $cId = 1;
                    } else {
                        $cId = $request->colorId;
                    }
                    if ($request->sizeId == '') {
                        $sId = 1;
                    } else {
                        $sId = $request->sizeId;
                    }
                    $request->validate([
                        'colorId' => 'required',
                        'sizeId' => 'required',
                    ], [
                        'colorId.required' => 'Please Select A Color.',
                        'sizeId.required' => 'Please Select A Size.',
                    ]);
                    Wishlist::insert([
                        'customerId' => Auth::guard('customerLogin')->id(),
                        'productId' => $request->productId,
                        'colorId' => $cId,
                        'sizeId' => $sId,
                        'created_at' => Carbon::now(),
                    ]);
                    return back()->with('wishlistInsert', 'Added to wishlist successfully.');
                }
            }
        } else {
            return back()->with('CostomerRegister', 'Welcome! Please Login to add to cart.');
        }
    }
    public function deleteCart($cartId)
    {
        Cart::find($cartId)->delete();
        return back();
    }
    public function wishlistDelete($wishlistId)
    {
        Wishlist::find($wishlistId)->delete();
        return back();
    }
    public function viewCart(Request $request)
    {
        $coupon = $request->coupon;
        $couponDetails = Coupon::where('couponName', $coupon)->get();
        $couponDiscount = null;
        $min = 0;
        $max = 0;
        $type = null;
        $msg = null;
        if ($coupon == '') {
            $couponDiscount = 0;
            $msg = 'If you have a coupon code, type that code for discount.';
            //$msg =  'Please Enter A Coupon Code.';
        } else {
            if (Coupon::where('couponName', $coupon)->exists()) {
                if (Carbon::now()->format('Y-m-d') > Coupon::where('couponName', $coupon)->first()->validity) {
                    $couponDiscount = 0;
                    $msg = 'This coupon validity date is expired.';
                } else {
                    $couponDiscount = Coupon::where('couponName', $coupon)->first()->couponDiscount;
                    $type = Coupon::where('couponName', $coupon)->first()->type;
                    $min = Coupon::where('couponName', $coupon)->first()->minimum;
                    $max = Coupon::where('couponName', $coupon)->first()->maximum;
                }
            } else {
                $couponDiscount = 0;
                $msg = 'This coupon does not exists right now.';
            }
        }
        $carts =  Cart::where('customerId', Auth::guard('customerLogin')->id())->get();
        return view('frontend.viewCart', [
            'carts' => $carts,
            'coupons' => $coupon,
            'couponDetail' => $couponDetails,
            'couponDiscounts' => $couponDiscount,
            'couponType' => $type,
            'minimum' => $min,
            'maximum' => $max,
            'msgs' => $msg,
        ]);
    }
    public function updateCart(Request $request)
    {
        foreach ($request->quantity as $cartId => $quantity) {
            Cart::find($cartId)->update([
                'quantity' => $quantity,
            ]);
        }
        return back()->with('updateCart', 'Cart Updated Successfully.');
    }
}
