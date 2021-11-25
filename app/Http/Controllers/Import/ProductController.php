<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Imports\ImagesOtherImport;
use App\Imports\ProductsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use ZanySoft\Zip\Zip;

class ProductController extends Controller
{
    public function import(Request $request)
    {

        set_time_limit(0);

        if ($request->hasFile('zip_product')) {
            $directory = 'product';
            Storage::deleteDirectory($directory);
            $zip = Zip::open($request->file('zip_product'));
            $zip->extract(public_path('uploads'));
        } elseif (Storage::exists('temp/product.zip')) {
            $directory = 'product';
            Storage::deleteDirectory($directory);
            $zip = Zip::open(Storage::path('temp/product.zip'));
            $zip->extract(public_path('uploads'));

            unset($zip);
            unlink(public_path('uploads/temp/product.zip'));
        }

        if ($request->hasFile('products_import')) {
            Excel::import(new ProductsImport(), request()->file('products_import'));
        }

        $request->session()->flash('success', 'Товары добавлены');
        return redirect()->back();

    }
}
