<?php

namespace App\Http\Controllers\Export;

use App\Exports\DeliveryExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DeliveryController extends Controller
{
    public function export()
    {
        return Excel::download(new DeliveryExport(), 'Выгрузка регионов доставки.xlsx');
    }
}
