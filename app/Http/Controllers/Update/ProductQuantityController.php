<?php

namespace App\Http\Controllers\Update;

use App\Http\Controllers\Controller;
use App\Imports\ProductsQuantitiesUpdate;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductQuantityController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'product_quantity_update' => 'required',
        ]);

        Excel::import(new ProductsQuantitiesUpdate(), request()->file('product_quantity_update'));
        $request->session()->flash('success', 'Количество товаров обновлены');
        return redirect()->back();

    }
}
