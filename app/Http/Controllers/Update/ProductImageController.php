<?php

namespace App\Http\Controllers\Update;

use App\Http\Controllers\Controller;
use App\Imports\ProductsImagesUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use ZanySoft\Zip\Zip;

class ProductImageController extends Controller
{
    public function import(Request $request)
    {
        set_time_limit(0);

        if ($request->hasFile('product_image_update')) {
            Excel::import(new ProductsImagesUpdate(), request()->file('product_image_update'));
        }

        if ($request->hasFile('zip_update_product_image')) {
            $zip = Zip::open($request->file('zip_update_product_image'));
            $zip->extract(public_path('uploads'));
        } elseif (Storage::exists('temp/product.zip')) {
            $zip = Zip::open(Storage::path('temp/product.zip'));
            $zip->extract(public_path('uploads'));

            unset($zip);
            unlink(public_path('uploads/temp/product.zip'));
        }

        $request->session()->flash('success', 'Изображения товаров обновлены');
        return redirect()->back();

    }
}
