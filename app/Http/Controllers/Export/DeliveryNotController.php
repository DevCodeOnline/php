<?php

namespace App\Http\Controllers\Export;

use App\Exports\DeliveryNotExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DeliveryNotController extends Controller
{
    public function export()
    {
        return Excel::download(new DeliveryNotExport(), 'Выгрузка регионов не доставки.xlsx');
    }
}
