<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Imports\InformationImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InformationController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'information_import' => 'required',
        ]);

        Excel::import(new InformationImport(), request()->file('information_import'));
        $request->session()->flash('success', 'Данные сайта добавлены');
        return redirect()->back();

    }
}
