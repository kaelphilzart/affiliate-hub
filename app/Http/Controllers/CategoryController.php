<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\categories\StoreCategoriesRequest;
use App\Http\Requests\categories\UpdateCategoriesRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return Inertia::render('category/Index', [
            'categories' => $categories,
        ]);
    }

    public function store(StoreCategoriesRequest $request)
    {
        $validated = $request->validated();

        Category::create($validated);

        return redirect()->route('category.index')->with('success', 'Category created successfully.');
    }

    public function update(UpdateCategoriesRequest $request, Category $category)
    {
        $validated = $request->validated();

        $category->update($validated);

        return redirect()->route('category.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
    }
}
