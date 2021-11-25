<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(25);
        $s = null;
        $id = null;
        return view('admin.products.index', compact('products', 's', 'id'));
    }

    /**
     * Search a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $products = Product::where('title', 'LIKE', "%$request->s%")->paginate(25);
        $s = $request->s;
        $id = null;
        return view('admin.products.index', compact('products', 's', 'id'));
    }

    public function searchId(Request $request)
    {
        $products = Product::where('id', 'LIKE', "%$request->id%")->paginate(25);
        $id = $request->id;
        $s = null;
        return view('admin.products.index', compact('products', 's', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('title', 'id');
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $max = Product::max('sort');
        $i = 1;
        if ($max) {
            $i += $max;
        }

        $product = Product::create([
            'id'           => $request->input('id'),
            'title'        => $request->input('title'),
            'description'  => $request->input('description'),
            'quantity'     => $request->input('quantity'),
            'price'        => $request->input('price'),
            'sort'         => $i,
        ]);

        if ($request->hasFile('images')) {
            $product->update([
                'image' => $request->file('images')[0]->store("product"),
            ]);
        }

        $images = [];

        if ($request->hasFile('images')) {
            // Добавляем новые изображения в папку
            $folder = 'product';
            foreach (array_slice($request->file('images'), 1) as $key => $value) {
                $images[] = $value->store("$folder");
            }
        }
        // Сохраняем новые изображение в таблицу Image
        if ($images) {
            foreach ($images as $image) {
                Image::create(['product_id' => $product->id, 'image' => $image]);
            }
        }

        // Синхронизируем категории

        $product->categories()->sync($request->categories);

        $request->session()->flash('success', 'Товар добавлена');

        return redirect()->route('products.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::pluck('title', 'id');

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $product = Product::find($id);


        // Обновляем товар

        $product->update([
            'id'           => $request->input('id'),
            'title'        => $request->input('title'),
            'description'  => $request->input('description'),
            'quantity'     => $request->input('quantity'),
            'price'        => $request->input('price'),
        ]);

        $images = [];

        if (!$product->image) {
            $product->update([
                'image' => $request->file('images')[0]->store("product"),
            ]);

            if ($request->hasFile('images')) {

                // Добавляем новые изображения в папку
                $folder = 'product';
                foreach (array_slice($request->file('images'), 1) as $key => $value) {
                    $images[] = $value->store("$folder");
                }
            }
            // Сохраняем новые изображение в таблицу Image
            if ($images) {
                foreach ($images as $image) {
                    Image::create(['product_id' => $product->id, 'image' => $image]);
                }
            }

        } else {
            if ($request->hasFile('images')) {

                // Добавляем новые изображения в папку
                $folder = 'product';
                foreach ($request->file('images') as $key => $value) {
                    $images[] = $value->store("$folder");
                }
            }
            // Сохраняем новые изображение в таблицу Image
            if ($images) {
                foreach ($images as $image) {
                    Image::create(['product_id' => $product->id, 'image' => $image]);
                }
            }
        }

        // Обновляем категории

        $product->categories()->sync($request->categories);

        // Обновляем дополнительные изображения


        $request->session()->flash('success', 'Товар изменен');
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $image = $product->image;
        $images = $product->images;

        if(is_file(str_replace('\\', '/', public_path("uploads/$image")))) {
            unlink(str_replace('\\', '/', public_path("uploads/$image")));
        }

        foreach ($images as $v) {
            if(is_file(str_replace('\\', '/', public_path("uploads/$v->image")))) {
                unlink(str_replace('\\', '/', public_path("uploads/$v->image")));
            }
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Товар удален');
    }

    public function destoryImages($id)
    {
        $image = Image::where('id', $id)->first();
        if(is_file(str_replace('\\', '/', public_path("uploads/$image->image")))) {
            unlink(str_replace('\\', '/', public_path("uploads/$image->image")));
        }
        $image->delete();
        return redirect()->back()->with('success', 'Дополниельное изображение удалено');
    }

    public function destoryImage($id)
    {
        $product = Product::where('id', $id)->first();

        if(is_file(str_replace('\\', '/', public_path("uploads/$product->image")))) {
            unlink(str_replace('\\', '/', public_path("uploads/$product->image")));
        }

        $product->update([
            'image' => null,
        ]);

        return redirect()->back()->with('success', 'Основное изображение удалено');
    }
}
