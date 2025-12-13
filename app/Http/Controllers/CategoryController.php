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
            "name" => "string|required|min:1|max:100"
        ]);

        $category = Category::create($validated);
        return response()->json([
            "success" => true,
            "message" => "Category created successfully: " . $category->name,
            "data" => $category
        ], 201);
    }

    public function show(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                "message" => "Couldn't find category with ID: " . $id
            ], 404);
        }

        return response()->json($category);
    }

    public function update(Request $request, string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(["message" => "Couldn't find category with ID: " . $id], 404);
        }

        $validated = $request->validate([
            "name" => "string|required|min:1|max:100"
        ]);

        $category->update($validated);

        return response()->json(["success" => true, "message" => "Category updated successfully"], 200);
    }

    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(["message" => "Couldn't find category with ID: " . $id], 404);
        }

        $category->delete();

        return response()->json(["message" => "Category with ID: " . $id . " deleted successfully!"], 200);
    }
}
