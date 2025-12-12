<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Order;
class OrderProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Order $order)
    {
        $validated = $request->validate([
            "quantity" => "integer|required|min:1|max:1000",
            "product_id" => "required|exists:products,id"
        ]);

        $productId = $validated["order_id"];

        $pivotData = collect($validated)->except("order_id", "product_id")->toArray();

        return response()->json("Connection created successfully", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }
}
