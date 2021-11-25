<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index($slug = null)
    {
        if ($slug) {
            $categories = Category::where('slug', $slug)->get();

            foreach ($categories as $item) {
                $category = $item;
            }
            $products = $category->products;

        } else {
            $category = Category::all();
            $products = Product::all();
        }

        return view('shop.category', compact('category', 'products', 'slug'));
    }
}
