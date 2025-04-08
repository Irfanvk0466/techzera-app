<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Product list page.
     */
    public function index()
    {
        $productList = Product::with(['images', 'variants'])->latest()->get();
        return view('website.frontend.home',compact('productList'));
    }
}
