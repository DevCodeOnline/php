<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsBestsUpdate implements ToCollection, SkipsOnError, SkipsEmptyRows, WithHeadingRow
{

    use SkipsErrors;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            //Получаем товар
            $product = Product::where('id', $row['id_product'])->first();

            $product->best()->detach();

            //Получаем лучшие товары
            $bests = explode(';', $row['id_best_product']);

            if ($bests) {
                foreach ($bests as $item) {
                    $product->best()->attach($item);
                }
            }
        }
    }
}
