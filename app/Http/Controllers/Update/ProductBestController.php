<?php

namespace App\Http\Controllers\Update;

use App\Http\Controllers\Controller;
use App\Imports\ProductsBestsUpdate;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductBestController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'product_best_update' => 'required',
        ]);

        Excel::import(new ProductsBestsUpdate(), request()->file('product_best_update'));
        $request->session()->flash('success', 'Лучшие товары обновлены');
        return redirect()->back();

    }
}
