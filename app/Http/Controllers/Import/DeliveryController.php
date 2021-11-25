<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Imports\DeliveriesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DeliveryController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'deliveries_import' => 'required',
        ]);

        Excel::import(new DeliveriesImport(), request()->file('deliveries_import'));
        $request->session()->flash('success', 'Регионы доставки добавлены');
        return redirect()->back();

    }
}
