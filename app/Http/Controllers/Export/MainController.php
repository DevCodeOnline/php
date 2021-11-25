<?php

namespace App\Http\Controllers\Export;

use App\Exports\MainExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MainController extends Controller
{
    public function export()
    {
        return Excel::download(new MainExport(), 'Выгрузка главной странице сайта.xlsx');
    }
}
