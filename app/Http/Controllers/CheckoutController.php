<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\BillingDetail;
use App\Models\BillingDetails;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderedProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function checkOut()
    {
        $cart = Cart::where('customerId', Auth::guard('customerLogin')->id())->get();
        $country = Country::all();
        return view('frontend.checkOut', [
            'carts' => $cart,
            'countries' => $country
        ]);
    }
    public function getCity(Request $request)
    {
        $str = '<select class="custom-select city" name="cityId">
        <option value="" disabled selected>-- Select City --</option>
      </select>';
        $city = City::where('country_id', $request->countryId)->get();
        foreach ($city as $cities) {
            $str .= '<select class="custom-select city" name="cityId">
            <option value="' . $cities->id . '">' . $cities->name . '</option>
          </select>';
        }
        echo $str;
    }
    public function orderStore(Request $request)
    {
        $city = City::find($request->cityId);
        $request->validate([
            'cityId' => 'required',
        ]);
        $orderId = '#' . Str::upper(substr($city->name, 0, 3)) . '-' . random_int(1000000, 9999999);
        if ($request->discount) {
            $total = $request->subTotal + $request->charge - $request->discount;
        } else {
            $total = $request->subTotal + $request->charge;
        }
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric|min:10',
            'address' => 'required',
            'countryId' => 'required',
            'postcode' => 'required',
            'charge' => 'required',
            'paymentMethod' => 'required',
        ], [
            'charge.required' => 'Please select a delivery location.',
        ]);
        if ($request->paymentMethod == 1) {
            Order::insertGetId([
                'orderId' => $orderId,
                'customerId' => Auth::guard('customerLogin')->id(),
                'subTotal' => $request->subTotal,
                'discount' => $request->discount,
                'charge' => $request->charge,
                'total' => $total,
                'paymentMethod' => $request->paymentMethod,
                'created_at' => Carbon::now(),
            ]);
            BillingDetail::insert([
                'orderId' => $orderId,
                'customerId' => Auth::guard('customerLogin')->id(),
                'name' => $request->name,
                'email' => $request->email,
                'company' => $request->company,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'countryId' => $request->countryId,
                'cityId' => $request->cityId,
                'zip' => $request->postcode,
                'notes' => $request->notes,
                'created_at' => Carbon::now(),
            ]);
            $carts = Cart::where('customerId', Auth::guard('customerLogin')->id())->get();
            foreach ($carts as $cart) {
                OrderedProduct::insert([
                    'orderId' => $orderId,
                    'customerId' => Auth::guard('customerLogin')->id(),
                    'productId' => $cart->productId,
                    'price' => $cart->relToProduct->afterDiscount,
                    'colorId' => $cart->colorId,
                    'sizeId' => $cart->sizeId,
                    'quantity' => $cart->quantity,
                ]);

                Inventory::where('productId', $cart->productId)->where('colorId', $cart->colorId)->where('sizeId', $cart->sizeId)->decrement('quantity', $cart->quantity);
            }

            Mail::to($request->email)->send(new InvoiceMail($orderId));
            //SMS
            $orderID = $orderId;
            $totalPay = $total;
            $url = "http://bulksmsbd.net/api/smsapi";
            $api_key = "50cRZUP4Wg5HLPcq5RLl";
            $senderid = "webdev_munna";
            $number = $request->mobile;
            $message = "Congratulations! Your order has been placed. The amount of order Tk" . $totalPay;

            $data = [
                "api_key" => $api_key,
                "senderid" => $senderid,
                "number" => $number,
                "message" => $message
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);

            Cart::where('customerId', Auth::guard('customerLogin')->id())->delete();
        } elseif ($request->paymentMethod == 2) {
            $allCheckoutInfo = $request->all();
            return redirect('/pay')->with('allCheckoutInfo', $allCheckoutInfo);
        } else {
            $allCheckoutInfo = $request->all();
            return redirect('/stripe')->with('allCheckoutInfo', $allCheckoutInfo);
        }
        return redirect()->route('orderSuccess')->with('orderId', $orderID);
    }
    public function orderSuccess()
    {
        return view('frontend.orderSuccess');
    }
}
