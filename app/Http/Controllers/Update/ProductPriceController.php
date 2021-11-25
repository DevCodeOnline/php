<?php

namespace App\Http\Controllers\Update;

use App\Http\Controllers\Controller;
use App\Imports\ProductsPricesUpdate;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductPriceController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'product_price_update' => 'required',
        ]);

        Excel::import(new ProductsPricesUpdate(), request()->file('product_price_update'));
        $request->session()->flash('success', 'Цены товаров обновлены');
        return redirect()->back();

    }
}
