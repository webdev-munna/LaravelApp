<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    public function customerOrder()
    {
        $orders = Order::orderBy('id', 'DESC')->get();
        return view('admin.customerOrder.customerOrder', [
            'allOrders' => $orders,
        ]);
    }
    public function customerOrderStatus(Request $request)
    {
        Order::find($request->orderId)->update([
            'orderStatus' => $request->status,
        ]);
        return back()->with('chngStatus', 'Order Status Changed Successfully.');
    }
    public function customerWishlist()
    {
        $wishList = Wishlist::where('customerId', Auth::guard('customerLogin')->id())->get();
        return view('frontend.customerWishlist', [
            'wishlists' => $wishList,
        ]);
    }
    public function delWishlist($wishListId)
    {
        Wishlist::find($wishListId)->delete();
        return back();
    }
}
