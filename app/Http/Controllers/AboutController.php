<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $information = Information::where('title', 'О нас')->get();
        foreach ($information as $item) {
            $info = $item;
        }

        return view('shop.about', compact('info'));
    }
}
