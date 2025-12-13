<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Order::with('user')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|min:1|max:100",
            "user_id" => "required|exists:users,id"
        ]);

        $order = Order::create($validated);
        return response()->json(["message" => "Order created successfully with ID: " . $order->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with('user')->find($id);
        
        if (!$order) {
            return response()->json(["message" => "Couldn't find order with ID: " . $id]);
        }
        
        return response()->json($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::find($id);
        
        if (!$order) {
            return response()->json(["message" => "Couldn't find order with ID: " . $id]);
        }

        $validated = $request->validate([
            "name" => "sometimes|required|string|min:1|max:100",
            "user_id" => "sometimes|required|exists:users,id"
        ]);

        $order->update($validated);
        
        return response()->json(["message" => "Order updated successfully with ID: " . $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::find($id);
        
        if (!$order) {
            return response()->json(["message" => "Couldn't find order with ID: " . $id]);
        }
        
        Order::destroy($id);
        return response()->json(["message" => "Order deleted successfully with ID: " . $id]);
    }
}