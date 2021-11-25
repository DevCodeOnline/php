<?php

namespace App\Http\Controllers\Export;

use App\Exports\CategoriesExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    public function export()
    {
        return Excel::download(new CategoriesExport(), 'Выгрузка структуры.xlsx');
    }
}
