<?php

namespace App\Http\Controllers\Update;

use App\Http\Controllers\Controller;
use App\Imports\ProductsTitlesUpdate;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductTitleController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'product_title_update' => 'required',
        ]);

        Excel::import(new ProductsTitlesUpdate(), request()->file('product_title_update'));
        $request->session()->flash('success', 'Название товаров обновлены');
        return redirect()->back();

    }
}
