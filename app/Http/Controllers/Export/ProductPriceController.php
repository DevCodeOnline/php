<?php

namespace App\Http\Controllers\Export;

use App\Exports\ProductsPricesExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductPriceController extends Controller
{
    public function export()
    {
        return Excel::download(new ProductsPricesExport(), 'Выгрузка цен товаров.xlsx');
    }
}
