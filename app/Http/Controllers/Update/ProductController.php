<?php

namespace App\Http\Controllers\Update;

use App\Http\Controllers\Controller;
use App\Imports\ProductsUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use ZanySoft\Zip\Zip;

class ProductController extends Controller
{
    public function import(Request $request)
    {
        set_time_limit(0);

        if ($request->hasFile('zip_update_product')) {
            $zip = Zip::open($request->file('zip_update_product'));
            $zip->extract(public_path('uploads'));
        } elseif (Storage::exists('temp/product.zip')) {
            $zip = Zip::open(Storage::path('temp/product.zip'));
            $zip->extract(public_path('uploads'));

            unset($zip);
            unlink(public_path('uploads/temp/product.zip'));
        }

        if ($request->hasFile('products_update')) {
            Excel::import(new ProductsUpdate(), request()->file('products_update'));
        }

        $request->session()->flash('success', 'Товары обновлены');
        return redirect()->back();

    }
}
