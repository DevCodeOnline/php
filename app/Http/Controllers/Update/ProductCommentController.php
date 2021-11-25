<?php

namespace App\Http\Controllers\Update;

use App\Http\Controllers\Controller;
use App\Imports\ProductsCommentsUpdate;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductCommentController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'product_comment_update' => 'required',
        ]);

        Excel::import(new ProductsCommentsUpdate(), request()->file('product_comment_update'));
        $request->session()->flash('success', 'Отзывы товаров обновлены');
        return redirect()->back();

    }
}
