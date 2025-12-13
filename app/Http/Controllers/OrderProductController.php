<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Order;
use Throwable;

class OrderProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Order $order)
    {
        $order->load("products");
        $order->load("user");
        return response()->json([
            "User name:" => $order->user->name,
            "Order" => $order->name,
            "Ordered the following item(s)" => $order->products->map(function ($product) {
                return [
                    "products_identifier" => $product->id,
                    "products_name" => $product->name,
                    "quantity" => $product->pivot->quantity
                ];
            })
        ],200);
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

        $productId = $validated["product_id"];

        $pivotData = collect($validated)->except("product_id")->toArray();

        $order->products()->attach($productId, $pivotData);
        return response()->json("Connection created successfully", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order, Product $product)
    {
        $order->load("user");
        $ordered_product = $order->products()->find($product->id);
        return response()->json(["User name:" => $order->user->name, "Order" => $ordered_product],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order, Product $product)
    {

        $order->load("user");
        $validated = $request->validate([
            "quantity" => "required|integer|min:1|max:1000"
        ]);
        $order->products()->updateExistingPivot($product->id, $validated);
        return response()->json(["message" => $order->user->name . "'s " . $order->name . " order updated, changed the " . $product->name . "'s quantity to" . $request->quantity], 200);

        if (!$order->products()->where("product_id", $product->id)->exists()) {
            return response()->json(["message" => $order->user->name . " doesn't have the product " . $product->name . " (id) " . $product->id . " in the order: " . $order->name . " (id)" . $order->id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order, Product $product)
    {
        $order->products()->detach($product->id);
        return response()->json(["Connection detached successfully!"],200);
    }
}
