<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::paginate(9);
        $categories = Category::all()->sortBy('sort');
        return view('shop.index', compact('products', 'categories'));
    }

    public function listing(Request $request)
    {
        $count = $request->input('value');
        $products = Product::paginate($count);
        return view('product.listing', compact('products'))->render();
    }
}
