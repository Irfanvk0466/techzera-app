<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\addCartRequest;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Add cart details to session using productId,variantId.
     */
    public function add(addCartRequest $request)
    {   
        $product = Product::findOrFail($request['product_id']);
        $variant = Variant::findOrFail($request['variant_id']);
        $cart = session()->get('cart', []);
        $itemKey = $product->id . '_' . $variant->id;

        if (isset($cart[$itemKey])) {
            $cart[$itemKey]['quantity'] += $request['quantity'];
        } else {
            $cart[$itemKey] = [
                'product_id' => $product->id,
                'variant_id' => $variant->id,
                'product_name' => $product->name,
                'variant_name' => $variant->variant_name,
                'price' => $variant->price,
                'quantity' => $request['quantity'],
                'image' => $product->images->first()->image_path ?? null,
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Item added to cart!');
    }

    /**
     * Show Cart Details.
     */
    public function show()
    {
        $cart = session()->get('cart', []);
        return view('website.frontend.cart', compact('cart'));
    }

    /**
     * Update Cart Details.
     */
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $key = $request->input('key');
        $quantity = (int) $request->input('quantity');
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = max(1, $quantity);
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Cart updated.');
    }

    /**
     * Remove Cart Details.
     */
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        $key = $request->input('key');

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Item removed from cart.');
    }
}
