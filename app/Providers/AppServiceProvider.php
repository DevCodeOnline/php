<?php

namespace App\Providers;

use App\Models\Information;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.layout', function ($view) {
            $favicon = Information::where('title', 'Favicon')->first();
            $view->with('favicon', $favicon);
        });

        view()->composer('admin.layouts.layout', function ($view) {
            $favicon = Information::where('title', 'Favicon')->first();
            $view->with('favicon', $favicon);
        });

        view()->composer('layouts.layout', function ($view) {
            $listing = DB::table('main_product');
            $list = $listing->orderBy('id')->pluck('new_product_id')->toArray();
            $products = collect();
            foreach ($list as $v) {
                $products->push(Product::where('id', $v)->first());
            }

            $view->with('products', $products);
        });

        view()->composer('layouts.layout', function ($view) {
            $logotip = Information::where('title', 'Логотип')->get();
            foreach ($logotip as $item) {
                $logo = $item;
            }
            $view->with('logo', $logo);
        });

        view()->composer('layouts.layout', function ($view) {
            $layout = Information::where('title', 'Подвал')->get();
            foreach ($layout as $item) {
                $footer = $item;
            }
            $view->with('footer', $footer);
        });

        view()->composer('layouts.best', function ($view) {
            $listing = DB::table('main_product');
            $list = $listing->orderBy('id')->pluck('best_product_id')->toArray();
            $products = collect();
            foreach ($list as $v) {
                $products->push(Product::where('id', $v)->first());
            }
            $view->with('products', $products);
        });

        Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }
}
