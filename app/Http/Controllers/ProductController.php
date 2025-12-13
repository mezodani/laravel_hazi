<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Product::with('category')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|min:1|max:100",
            "category_id" => "required|exists:categories,id"
        ]);

        $product = Product::create($validated);
        return response()->json(["message" => "Product added with ID: " . $product->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('category')->find($id);
        
        if (!$product) {
            return response()->json(["message" => "Couldn't find product with ID: " . $id]);
        }
        
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(["message" => "Couldn't find product with ID: " . $id]);
        }

        $validated = $request->validate([
            "name" => "sometimes|required|string|min:1|max:100",
            "category_id" => "sometimes|required|exists:categories,id"
        ]);

        $product->update($validated);
        
        return response()->json(["message" => "Product updated successfully with ID: " . $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(["message" => "Couldn't find product with ID: " . $id]);
        }

        Product::destroy($id);
        
        return response()->json(["message" => "Product deleted successfully with ID: " . $id]);
    }
}