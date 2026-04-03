<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoryName' => 'required|string|max:255',
            'minFlowRate' => 'required|numeric',
            'maxFlowRate' => 'required|numeric',
        ]);

        $category = Category::create($validated);
        return response()->json(['message' => 'Category created successfully', 'data' => $category], 201);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'categoryName' => 'required|string|max:255',
            'minFlowRate' => 'required|numeric',
            'maxFlowRate' => 'required|numeric',
        ]);

        $category->update($validated);
        return response()->json(['message' => 'Category updated successfully', 'data' => $category]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
