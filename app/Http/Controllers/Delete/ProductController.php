<?php

namespace App\Http\Controllers\Delete;

use App\Http\Controllers\Controller;
use App\Imports\ProductDelete;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'products_delete' => 'required',
        ]);

        Excel::import(new ProductDelete(), request()->file('products_delete'));
        $request->session()->flash('success', 'Товары удалены');
        return redirect()->back();

    }
}
