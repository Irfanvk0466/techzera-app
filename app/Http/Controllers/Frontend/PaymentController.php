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
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        $selectedKeys = $request->input('selected_items', []);
        $selectedItems = [];
        $total = 0;
        foreach ($selectedKeys as $key) {
            if (isset($cart[$key])) {
                $selectedItems[$key] = $cart[$key];
                $total += $cart[$key]['price'] * $cart[$key]['quantity'];
            }
        }
        if (empty($selectedItems)) {
            return redirect()->back()->with('danger', 'Please select at least one item to checkout.');
        }
        session()->put('selected_cart', $selectedItems);
        session()->put('selected_total', $total);
        return view('website.frontend.checkout', [
            'selectedItems' => $selectedItems,
            'total' => $total,
        ]);
    }

    /**
     * store payment and the order details.
     */
    public function store(checkoutRequest $request)
    {
        $shippingDetails = $request->validated();
        $selectedCart = session()->get('selected_cart', []);
        $total = session()->get('selected_total', 0);

        if (empty($selectedCart)) {
            return redirect()->route('cart.show')->with('error', 'Your cart is empty.');
        }

        session()->put('shipping_details', $shippingDetails);
        session()->put('order_total', $total);
        session()->put('order_items', $selectedCart);

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
    
        $cart = session()->get('cart', []);
        $selected = session()->get('selected_cart', []);
    
        foreach ($selected as $key => $item) {
            unset($cart[$key]);
        }
    
        session()->put('cart', $cart);
        session()->forget(['selected_cart', 'selected_total', 'shipping_details', 'order_items', 'order_total']);
        return view('website.frontend.order-confirmation', compact('paymentId', 'shipping', 'items', 'total', 'orderId'));
    }
    

}
