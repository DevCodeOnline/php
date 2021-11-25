<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Information::where('title', 'Оплата и доставка')->get();
        foreach ($payments as $item) {
            $payment = $item;
        }

        return view('shop.payment', compact('payment'));
    }
}
