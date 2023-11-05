<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\BillingDetail;
use App\Models\Cart;
use App\Models\City;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderedProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\allData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Session;
use Stripe;
use Str;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        $allData = session('allInfo');
        $city = City::find($allData['cityId']);
        $orderId = '#' . Str::upper(substr($city->name, 0, 3)) . '-' . random_int(1000000, 9999999);
        $total = $allData['subTotal'] + $allData['charge'] - $allData['discount'];

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create([
            "amount" => 100 * $total,
            "currency" => "bdt",
            "source" => $request->stripeToken,
            "description" => "Test payment from itsolutionstuff.com."
        ]);
        Order::insertGetId([
            'orderId' => $orderId,
            'customerId' => Auth::guard('customerLogin')->id(),
            'subTotal' => $allData['subTotal'],
            'discount' => $allData['discount'],
            'charge' => $allData['charge'],
            'total' => $total,
            'paymentMethod' => 3,
            'created_at' => Carbon::now(),
        ]);
        BillingDetail::insert([
            'orderId' => $orderId,
            'customerId' => Auth::guard('customerLogin')->id(),
            'name' => $allData['name'],
            'email' => $allData['email'],
            'company' => $allData['company'],
            'mobile' => $allData['mobile'],
            'address' => $allData['address'],
            'countryId' => $allData['countryId'],
            'cityId' => $allData['cityId'],
            'zip' => $allData['postcode'],
            'notes' => $allData['notes'],
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

        Mail::to($allData['email'])->send(new InvoiceMail($orderId));
        //SMS
        $orderID = $orderId;
        $totalPay = $total;
        $url = "http://bulksmsbd.net/api/smsapi";
        $api_key = "50cRZUP4Wg5HLPcq5RLl";
        $senderid = "webdev_munna";
        $number = $allData['mobile'];
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

        return redirect()->route('orderSuccess');
    }
}
