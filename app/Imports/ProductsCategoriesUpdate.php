<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsCategoriesUpdate implements ToCollection, SkipsOnError, SkipsEmptyRows, WithHeadingRow
{

    use SkipsErrors;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            //Получаем товар
            $product = Product::where('id', $row['id_product'])->first();

            if($product) {
                $product->categories()->detach();

                // Получаем все категории
                $categories = Category::all()->whereIn('title', explode(';', $row['categories']));

                // Добавляем категории к товару
                if ($categories) {
                    $arr = array();
                    foreach ($categories as $k => $v) {
                        array_push($arr, $v->id);
                    }
                    $product->categories()->attach($arr);
                }
            }
        }
    }
}
