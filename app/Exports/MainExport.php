<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class MainExport implements FromView
{
    public function view(): View
    {
        return view('export.main', [
            'mains' => DB::table('main_product')->get()
        ]);
    }
}
