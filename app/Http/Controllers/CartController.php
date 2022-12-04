<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->user()->mainCart();
        return view('cart.index', compact('cart'));
    }

    public function addToCart(Request $request, int $product_id)
    {
        $product = Product::find($product_id);

        if (!$product) {
            return abort(Response::HTTP_NOT_FOUND, 'Product not found');
        }

        $cart = $request->user()->mainCart();

        if ($cartItem = $cart->items()->where('product_id', $product_id)->first()) {
            $cartItem->quantity++;
            $cartItem->save();
        } else {
            $cart->items()->create([
                'product_id' => $product_id,
                'quantity' => 1,
            ]);
        }

        return back()->with('status', 'Product added to cart');
    }

    public function removeFromCart(Request $request, int $product_id)
    {
        $cart = $request->user()->mainCart();

        $cartItem = $cart->items()->where('product_id', $product_id)->first();

        if (!$cartItem) {
            return abort(Response::HTTP_NOT_FOUND, 'Product not found');
        }

        $cartItem->delete();

        return back()->with('status', 'Product removed from cart');
    }
}
