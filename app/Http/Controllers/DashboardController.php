<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\TrackAudience;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCategories = Category::count();
        $totalProducts = Product::count();

        return Inertia::render('Dashboard', [
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalAudienceClick' => TrackAudience::count(),

            'latestProducts' => Product::with('category')
                ->latest()
                ->take(5)
                ->get(),

            'latestCategories' => Category::latest()
                ->take(5)
                ->get(),

            'hasMoreCategories' => $totalCategories > 5,
            'hasMoreProducts' => $totalProducts > 5,
        ]);
    }
}
