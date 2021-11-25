<?php

namespace App\Imports;

use App\Models\Information;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InformationImport implements ToCollection, SkipsOnError, SkipsEmptyRows, WithHeadingRow
{

    use SkipsErrors;

    public function collection(Collection $rows)
    {
        Information::query()->delete();
        User::query()->delete();
        foreach ($rows as $row)
        {
            if ($row['title'] == 'Админка') {
                User::create([
                    'name'      => 'admin',
                    'email'     => $row['image'],
                    'password'  => Hash::make($row['content'])
                ]);
            }  else {
                Information::create([
                    'title'      => $row['title'],
                    'image'      => $row['image'],
                    'content'    => $row['content']
                ]);
            }
        }
    }
}
