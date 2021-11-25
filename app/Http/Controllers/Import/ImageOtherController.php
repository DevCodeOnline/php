<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Imports\ImagesOtherImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use ZanySoft\Zip\Zip;

class ImageOtherController extends Controller
{
    public function import(Request $request)
    {

        set_time_limit(0);

        if ($request->hasFile('zip_other')) {
            $directory = 'other';
            Storage::deleteDirectory($directory);

            $zip = Zip::open($request->file('zip_other'));
            $zip->extract(public_path('uploads'));
        }

        if ($request->hasFile('image_other_import')) {
            Excel::import(new ImagesOtherImport(), request()->file('image_other_import'));
        }

        $request->session()->flash('success', 'Вспомогательные изображения добавлены');
        return redirect()->back();

    }
}
