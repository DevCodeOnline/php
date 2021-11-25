<?php

namespace App\Http\Controllers\Export;

use App\Exports\ImageOtherExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImageOtherController extends Controller
{
    public function export()
    {
        return Excel::download(new ImageOtherExport(), 'Выгрузка вспомогательных изображений.xlsx');
    }
}
