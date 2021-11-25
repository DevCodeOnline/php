<?php

namespace App\Http\Controllers\Update;

use App\Http\Controllers\Controller;
use App\Imports\ProductsDescriptionsUpdate;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductDescriptionController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'product_description_update' => 'required',
        ]);

        Excel::import(new ProductsDescriptionsUpdate(), request()->file('product_description_update'));
        $request->session()->flash('success', 'Описание товаров обновлены');
        return redirect()->back();

    }
}
