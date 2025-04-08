<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    /**
     * Show product Details.
     */
    public function show(Product $product, Variant $variant)
    {
        if ($variant->product_id !== $product->id) {
            abort(404);
        }
        $data = $product->load('images', 'variants');
        return view('website.frontend.details', compact('product', 'variant'));
    }
}
