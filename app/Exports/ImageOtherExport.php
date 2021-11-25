<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class ImageOtherExport implements FromView
{
    public function view(): View
    {
        return view('export.other', [
            'others' => DB::table('images_other')->get()
        ]);
    }
}
