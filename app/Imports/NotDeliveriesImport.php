<?php

namespace App\Imports;

use App\Models\Delivery;
use App\Models\Region;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NotDeliveriesImport implements ToCollection, SkipsOnError, SkipsEmptyRows, WithHeadingRow
{

    use SkipsErrors;

    public function collection(Collection $rows)
    {
        DB::table('delivery_not_region')->truncate();
        foreach ($rows as $row) {

            // Проверяем существует ли такой способ доставки
            $delivery = Delivery::where('title', $row['delivery'])->first();

            if ($delivery === null) {
                $delivery = Delivery::create([
                    'title' => $row['delivery']
                ]);
            }

            $delivery->notRegion()->attach([
                $delivery->id => ['title' => $row['not_region']],
            ]);
        }
    }
}
