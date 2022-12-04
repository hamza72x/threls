<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getHome(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isBuyer()) {
            return view('products.index')->with([
                'products' => Product::paginate(Product::PAGINATE_ITEMS),
            ]);
        }

        return redirect()->route('dashboard');
    }
}
