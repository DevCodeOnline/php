<?php

namespace App\Http\Controllers;

use App\Mail\ReviewMail;
use App\Models\Information;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Ixudra\Curl\Facades\Curl;

class ProductController extends Controller
{
    public function index(Request $request ,$slug)
    {
        $products = Product::where('slug', $slug)->get();
        foreach ($products as $item) {
            $product = $item;
        }
        $bests = $product->best;

        return view('shop.product', compact('product', 'bests'));
    }

    public function review(Request $request)
    {
        // Валидация
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
        ]);

        $data = $request->all();

        $info = Information::where('title', 'E-mail-логин')->first();

        Mail::to($info->content)->send(new ReviewMail($data));

        $request->session()->flash('success', 'Отзыв отправлен');

        return redirect()->back();
    }
}
