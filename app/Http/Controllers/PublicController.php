<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Inertia\Inertia;

class PublicController extends Controller
{
    public function index()
    {
        return Inertia::render('Welcome', [
            'products' => Product::with('category')->latest()->get(),
            'categories' => Category::latest()->get(),
        ]);
    }
}
