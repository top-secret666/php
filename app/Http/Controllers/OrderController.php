<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('user')->paginate(20);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->validated());
        return redirect()->route('orders.show', $order);
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function update(StoreOrderRequest $request, Order $order)
    {
        $order->update($request->validated());
        return redirect()->route('orders.show', $order);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index');
    }
}
