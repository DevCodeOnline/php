<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(25);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
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
            'id' => 'required',
            'title' => 'required',
            'image' => 'nullable|image'
        ]);

        // Проверяем есть ли основное изображение

        if ($request->hasFile('image')) {
            $folder = 'category';
            $data['image'] = $request->file('image')->store("$folder");
        }

        $max = Category::max('sort');
        $i = 1;
        if ($max) {
            $i += $max;
        }

        $category = Category::create([
            'id'    => $request->input('id'),
            'title' => $request->input('title'),
            'image' => $data['image'],
            'sort'  => $i
        ]);
        $request->session()->flash('success', 'Категория добавлена');
        return redirect()->route('categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.categories.edit', compact('category'));
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
            'image' => 'nullable|image'
        ]);

        $data = $request->all();

        $category = Category::find($id);

        // Проверяем есть ли основное изображение

        if ($request->hasFile('image')) {
            Storage::delete($category->image);
            $folder = 'category';
            $data['image'] = $request->file('image')->store("$folder");
        }

        $category->update($data);

        $request->session()->flash('success', 'Категория изменена');
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category->image) {
            Storage::delete($category->image);
        }
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Категория удалена');
    }
}
