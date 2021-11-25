<?php

namespace App\Http\Controllers\Export;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function export()
    {
        return Excel::download(new ProductsExport(), 'Выгрузка товаров.xlsx');
    }
}
