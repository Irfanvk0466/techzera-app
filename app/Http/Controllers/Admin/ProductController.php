<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('images', 'variants')->latest()->paginate(5);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        $product->saveImages($request->file('images'));
        $product->saveVariants($request->variant_name, $request->variant_price);
        return redirect()->route('admin.products.index')->with('success', 'Product Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::with('images', 'variants')->findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        $this->syncImages($product, $request);
        $this->syncVariants($product, $request);
        $this->addNewVariants($product, $request);
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Handle images while update.
     */
    private function syncImages(Product $product, UpdateProductRequest $request): void
    {
        $existingImageIds = $request->input('existing_image_ids', []);
        foreach ($product->images as $image) {
            if (!in_array($image->id, $existingImageIds)) {
                Storage::disk('public')->delete('products/' . $image->image_path);
                $image->delete();
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . rand(1, 99) . '.' . $image->extension();
                $image->storeAs('products', $imageName, 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imageName
                ]);
            }
        }
    }

    /**
     * Handle variants while update.
     */
    private function syncVariants(Product $product, UpdateProductRequest $request): void
    {
        if ($request->has('removed_variant_ids')) {
            Variant::whereIn('id', $request->removed_variant_ids)->delete();
        }

        if ($request->has('variant_ids')) {
            foreach ($request->variant_ids as $index => $variantId) {
                $variant = Variant::find($variantId);
                if ($variant) {
                    $variant->update([
                        'variant_name' => $request->variant_name[$index],
                        'price' => $request->variant_price[$index],
                    ]);
                }
            }
        }
    }

    /**
     * Add new variants while update.
     */
    private function addNewVariants(Product $product, UpdateProductRequest $request): void
    {
        if ($request->has('new_variant')) {
            $startIndex = count($request->variant_ids ?? []);
            foreach ($request->new_variant as $key => $val) {
                $product->variants()->create([
                    'variant_name' => $request->variant_name[$startIndex + $key],
                    'price' => $request->variant_price[$startIndex + $key],
                ]);
            }
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}
