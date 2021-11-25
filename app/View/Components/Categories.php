<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\Component;

class Categories extends Component
{
    public $count;
    public $sort;
    public $value;
    public $slug;
    public $layout;
    public $page;

    /**
     * Create a new component instance.
     *
     * @param int $count
     */
    public function __construct()
    {
        $this->count = request()->show ?? 20;
        if (request()->sort) {
            $arr = explode('[', trim(request()->sort, ']'));
            $this->sort = array_shift($arr);
            $this->value = array_shift($arr);
        } else {
            $this->sort = 'sort';
            $this->value = 'asc';
        }

        if (request()->slug) {
            $this->slug = request()->slug;
        }
        $this->layout = request()->layout ?? 'grid';
        $this->page = request()->page ?? 1;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if ($this->slug) {
            $categories = Category::where('slug', $this->slug)->get();
            foreach ($categories as $item) {
                $product = $item;
            }

            $layout = $this->layout;

            $products = $product->products()->orderBy($this->sort, $this->value)->paginate($this->count);

            return view('components.categories', compact('products', 'layout'))->render();
        } else {
            $products = Product::orderBy($this->sort, $this->value)->paginate($this->count, $columns = ['*'], $pageName = 'page', $page = $this->page);
            $layout = $this->layout;
            return view('components.categories', compact('products', 'layout'))->render();
        }

    }

    public function update(Request $request)
    {
        if ($request->input('sort')) {
            $arr = explode('[', trim($request->input('sort'), ']'));
            $this->sort = array_shift($arr);
            $this->value = array_shift($arr);
        }

        if ($request->input('show')) {
            $this->count = $request->input('show');
        }

        if ($request->input('layout')) {
            $this->layout = $request->input('layout');
        }

        if ($request->input('page')) {
            $this->page = $request->input('page');
        }

        return $this->render();
    }
}
