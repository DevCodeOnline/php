<?php

namespace App\Exports;

use App\Models\Delivery;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DeliveryNotExport implements FromView
{
    public function view(): View
    {
        return view('export.deliveriesNotRegions', [
            'deliveries' => Delivery::all()
        ]);
    }
}
