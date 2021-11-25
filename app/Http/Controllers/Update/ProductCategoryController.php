<?php

namespace App\Http\Controllers\Update;

use App\Http\Controllers\Controller;
use App\Imports\ProductsCategoriesUpdate;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductCategoryController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'product_category_update' => 'required',
        ]);

        Excel::import(new ProductsCategoriesUpdate(), request()->file('product_category_update'));
        $request->session()->flash('success', 'Категории товаров обновлены');
        return redirect()->back();

    }
}
