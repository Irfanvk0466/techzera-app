<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\checkoutRequest;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * chekout the order before payment.
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'Your cart is empty.');
        }
        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        return view('website.frontend.checkout', compact('cart', 'total'));
    }

    /**
     * store payment and the order details.
     */
    public function store(checkoutRequest $request)
    {
        $shippingDetails = $request->validated();
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'Your cart is empty.');
        }
        session()->put('shipping_details', $shippingDetails);
        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        session()->put('order_total', $total);
        session()->put('order_items', $cart);
        return view('website.frontend.payment', compact('total'));
    }

    /**
     * payment success confirm.
     */
    public function orderConfirmation(Request $request)
    {
        $paymentId = $request->query('payment_id');
        $shipping = session('shipping_details');
        $items = session('order_items');
        $total = session('order_total');
        $orderId = strtoupper('ORD-' . substr(md5($paymentId), 0, 8));

        session()->forget('cart');
        return view('website.frontend.order-confirmation', compact('paymentId', 'shipping', 'items', 'total', 'orderId'));
    }

}
