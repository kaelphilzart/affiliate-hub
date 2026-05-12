<?php

namespace App\Http\Controllers;

use App\Http\Requests\products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Inertia\Inertia;

class ProductController extends Controller
{
    // INDEX
    // ======================================================================================================
    public function index()
    {
        return Inertia::render('products/Index', [
            'products' => Product::with('category')
                ->withCount(['audiences as clicks'])
                ->latest()
                ->get(),
            'categories' => Category::latest()->get(),
            'tracks',
        ]);
    }

    // STORE
    // ======================================================================================================
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $filename = time().'.'.$file->extension();

            $file->move(public_path('storage/products'), $filename);

            $validated['image'] = 'storage/products/'.$filename;
        }

        Product::create($validated);

        return redirect()->route('products.index');
    }

    // UPDATE
    // ======================================================================================================
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $filename = time().'.'.$file->extension();

            $file->move(public_path('storage/products'), $filename);

            $validated['image'] = 'storage/products/'.$filename;
        } else {

            unset($validated['image']);
        }

        $product->update($validated);

        return back()->with([
            'success' => 'Product updated successfully',
        ]);
    }

    // DELETE
    // ======================================================================================================
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index');
    }
}
