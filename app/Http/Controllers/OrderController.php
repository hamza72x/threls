<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return view('orders.index')->with([
            'orders' => $request->user()->orders()->get(),
        ]);
    }

    public function placeMainCart(Request $request)
    {
        $user = $request->user();
        $cart = $user->mainCart();

        if ($cart->items()->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        DB::beginTransaction();

        // create order
        $order = Order::create([
            'user_id' => $user->id,
            'grand_total' => 0,
            'status' => Order::STATUS_PENDING,
        ]);

        $grand_total = 0;
        // create order items
        foreach ($cart->items as $item) {
            $sub_total = $item->product->price * $item->quantity;

            $order->items()->create([
                'product_id' => $item->product_id,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'sub_total' => $sub_total,
            ]);
           
            $grand_total += $sub_total;
        }

        $order->grand_total = $grand_total;
        $order->save();

        // remove items from cart
        $cart->items()->delete();

        DB::commit();

        return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully');
    }

    public function show(Request $request, int $order_id)
    {
        $order = $request->user()->orders()->where('id', $order_id)->first();

        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found');
        }

        return view('orders.show')->with([
            'order' => $order,
        ]);
    }
}
