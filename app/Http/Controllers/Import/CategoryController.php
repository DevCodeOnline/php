<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Imports\CategoriesImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use ZanySoft\Zip\Zip;

class CategoryController extends Controller
{
    public function import(Request $request)
    {
        set_time_limit(0);

        if ($request->hasFile('zip_category')) {
            $directory = 'category';
            Storage::deleteDirectory($directory);

            $zip = Zip::open($request->file('zip_category'));
            $zip->extract(public_path('uploads'));
        }

        if ($request->hasFile('categories_import')) {
            Excel::import(new CategoriesImport(), request()->file('categories_import'));
        }

        $request->session()->flash('success', 'Категории добавлены');
        return redirect()->back();

    }
}
