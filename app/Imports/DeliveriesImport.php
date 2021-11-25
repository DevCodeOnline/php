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

class DeliveriesImport implements ToCollection, SkipsOnError, SkipsEmptyRows, WithHeadingRow
{

    use SkipsErrors;

    public function collection(Collection $rows)
    {
        Region::query()->delete();
        DB::table('delivery_region')->truncate();
        DB::table('delivery_not_region')->truncate();
        foreach ($rows as $row) {

            // Проверяем существует ли такой способ доставки
            $delivery = Delivery::where('title', $row['delivery'])->first();

            if ($delivery === null) {
                $delivery = Delivery::create([
                    'title' => $row['delivery']
                ]);
            }

            // Проверяем существует ли такой регион
            $region = Region::where('title', $row['region'])->first();

            if ($region === null) {
                $region = Region::create([
                    'title' => $row['region']
                ]);
            }

            $delivery->region()->attach([
                $region->id => ['days' => $row['days'], 'value' => $row['price'], 'percent' => $row['percent'], 'status' => '1'],
            ]);
        }
    }
}
