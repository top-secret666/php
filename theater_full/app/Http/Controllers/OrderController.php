<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        // Orders are personal: only authenticated users.
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = $request->user();

        $ordersQuery = Order::query()->with('user');

        if (!$user?->is_admin) {
            $ordersQuery->where('user_id', $user->id);
        }

        $orders = $ordersQuery->orderByDesc('id')->paginate(20);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();

        $user = $request->user();

        // Regular users can only create orders for themselves.
        if (!$user?->is_admin) {
            $data['user_id'] = $user->id;
        } else {
            // Admin may omit user_id; default to self.
            $data['user_id'] = $data['user_id'] ?? $user->id;
        }

        $order = Order::create($data);
        return redirect()->route('orders.show', $order);
    }

    public function show(Order $order)
    {
        $user = Auth::user();
        if (!$user?->is_admin && (int) $order->user_id !== (int) $user->id) {
            abort(403);
        }

        $order->load(['user', 'tickets.seat', 'tickets.performance.show']);
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $user = Auth::user();
        if (!$user?->is_admin && (int) $order->user_id !== (int) $user->id) {
            abort(403);
        }
        return view('orders.edit', compact('order'));
    }

    public function update(StoreOrderRequest $request, Order $order)
    {
        $user = $request->user();
        if (!$user?->is_admin && (int) $order->user_id !== (int) $user->id) {
            abort(403);
        }

        $data = $request->validated();

        // Regular users cannot reassign orders.
        if (!$user?->is_admin) {
            unset($data['user_id']);
        }

        $order->update($data);
        return redirect()->route('orders.show', $order);
    }

    public function destroy(Order $order)
    {
        $user = Auth::user();
        if (!$user?->is_admin && (int) $order->user_id !== (int) $user->id) {
            abort(403);
        }
        $order->delete();
        return redirect()->route('orders.index');
    }
}
