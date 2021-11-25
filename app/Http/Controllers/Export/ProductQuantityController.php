<?php

namespace App\Http\Controllers\Export;

use App\Exports\ProductsQuantitiesExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductQuantityController extends Controller
{
    public function export()
    {
        return Excel::download(new ProductsQuantitiesExport(), 'Выгрузка количества товаров.xlsx');
    }
}
