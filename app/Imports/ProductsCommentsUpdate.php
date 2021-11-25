<?php

namespace App\Imports;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsCommentsUpdate implements ToCollection, SkipsOnError, SkipsEmptyRows, WithHeadingRow
{

    use SkipsErrors;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            //Получаем товар
            $product = Product::where('id', $row['id_product'])->first();
            foreach ($product->comments as $comment) {
                Comment::where('id', $comment->id)->delete();
            }

            $reviews = explode('|', $row['reviews']);

            if ($reviews) {
                foreach ($reviews as $review) {
                    $comment = Comment::create(['content' => $review]);
                    $product->comments()->attach($comment->id);
                }
            }

        }
    }
}
