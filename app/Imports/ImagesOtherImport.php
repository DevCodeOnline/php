<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImagesOtherImport implements ToCollection, SkipsOnError, SkipsEmptyRows, WithHeadingRow
{

    use SkipsErrors;

    public function collection(Collection $rows)
    {
        DB::table('images_other')->truncate();
        foreach ($rows as $row)
        {
            DB::table('images_other')->insert([
                'id' => $row['id_image'],
                'image' => $row['image']
            ]);
        }
    }
}
