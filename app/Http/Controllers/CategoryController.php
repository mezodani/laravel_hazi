<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "string|required|min:1|max:100"
        ]);
        if (!$validated) {
            return response()->json(["message" => "Hiba"]);
        }
        $category = Category::create($validated);
        return response() -> json(["success"=>true, "message"=> "Category created successfully, ".$category->name." . ID: ".$category->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        if(!$category) {
            return response() -> json(["message" => "Couldn't find category with ID: ".$id]);
        }
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if(!$category) {
            return response() -> json(["message" => "Couldn't find category with ID: ".$id]);
        }
        Category::destroy($id);
        return response()->json(["message" => "Category with ID: ".$id." deleted successfully!"]);
    }
}
