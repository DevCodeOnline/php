<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZanySoft\Zip\Zip;

class ZipController extends Controller
{
    public function other(Request $request)
    {
        set_time_limit(0);
        $request->validate([
            'zip_other' => 'required',
        ]);

        $directory = 'other';
        Storage::deleteDirectory($directory);

        $zip = Zip::open($request->file('zip_other'));
        $zip->extract(public_path('uploads'));

        $request->session()->flash('success', 'Вспомогательные изображения загружены');
        return redirect()->route('admin.index');
    }

    public function category(Request $request)
    {
        set_time_limit(0);
        $request->validate([
            'zip_category' => 'required',
        ]);

        $directory = 'category';
        Storage::deleteDirectory($directory);

        $zip = Zip::open($request->file('zip_category'));
        $zip->extract(public_path('uploads'));

        $request->session()->flash('success', 'Изображения для структуры загружены');
        return redirect()->route('admin.index');
    }

    public function product(Request $request)
    {
        set_time_limit(0);
        $request->validate([
            'zip_product' => 'required',
        ]);

        $directory = 'product';
        Storage::deleteDirectory($directory);

        $zip = Zip::open($request->file('zip_product'));
        $zip->extract(public_path('uploads'));

        $request->session()->flash('success', 'Изображения для товаров загружены');
        return redirect()->route('admin.index');
    }

    public function data(Request $request)
    {
        set_time_limit(0);;
        $request->validate([
            'zip_data' => 'required',
        ]);

        $directory = 'data';
        Storage::deleteDirectory($directory);

        $zip = Zip::open($request->file('zip_data'));
        $zip->extract(public_path('uploads'));

        $request->session()->flash('success', 'Изображения для данных сайта загружены');
        return redirect()->route('admin.index');
    }

    public function updateProduct(Request $request)
    {
        set_time_limit(0);
        $request->validate([
            'zip_update_product' => 'required',
        ]);

        $zip = Zip::open($request->file('zip_update_product'));
        $zip->extract(public_path('uploads'));

        $request->session()->flash('success', 'Изображения товаров добавлены к существующим');
        return redirect()->route('admin.index');
    }

    public function updateProductImage(Request $request)
    {
        set_time_limit(0);
        $request->validate([
            'zip_update_product_image' => 'required',
        ]);

        $zip = Zip::open($request->file('zip_update_product_image'));
        $zip->extract(public_path('uploads'));

        $request->session()->flash('success', 'Изображения для товаров добавлены к существующим');
        return redirect()->route('admin.index');
    }
}
