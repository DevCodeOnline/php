<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Imports\MainPageImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MainPageController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'main_page_import' => 'required',
        ]);

        Excel::import(new MainPageImport(), request()->file('main_page_import'));
        $request->session()->flash('success', 'Данные главной странице добавлены');
        return redirect()->back();

    }
}
