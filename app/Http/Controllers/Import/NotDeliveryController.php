<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Imports\NotDeliveriesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class NotDeliveryController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'not_deliveries_import' => 'required',
        ]);

        Excel::import(new NotDeliveriesImport(), request()->file('not_deliveries_import'));
        $request->session()->flash('success', 'Регионы не доставки добавлены');
        return redirect()->back();

    }
}
