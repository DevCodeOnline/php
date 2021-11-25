<?php

namespace App\Exports;

use App\Models\Delivery;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DeliveryExport implements FromView
{
    public function view(): View
    {
        return view('export.deliveriesRegions', [
            'deliveries' => Delivery::all()
        ]);
    }
}
