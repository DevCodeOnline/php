<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductsPricesExport implements FromView
{
    public function view(): View
    {
        return view('export.prices', [
            'products' => Product::all()
        ]);
    }
}
