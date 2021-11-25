<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request, $page = 9)
    {
        $request->validate([
           's' => 'required'
        ]);

        $s = $request->s;
        //$products = Product::where('title', 'LIKE', "%$s%")->paginate($page);

        return view('shop.search', compact('s'));
    }
}
