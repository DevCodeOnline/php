<?php

namespace App\Imports;

use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoriesImport implements ToCollection, SkipsOnError, SkipsEmptyRows, WithHeadingRow
{

    use SkipsErrors;

    public function collection(Collection $rows)
    {
        Category::query()->delete();
        $i = 1;
        foreach ($rows as $row)
        {
            Category::create([
                'id'        => $row['id_category'],
                'title'     => $row['title'],
                'image'     => $row['image'],
                'sort'      => $i,
            ]);
            $i++;
        }
    }
}
