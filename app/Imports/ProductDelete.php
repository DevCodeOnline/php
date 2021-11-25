<?php

namespace App\Imports;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductDelete implements ToCollection, SkipsOnError, SkipsEmptyRows, WithHeadingRow
{

    use SkipsErrors;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $product = Product::where('id', $row['id_product'])->first();
            if($product) {
                foreach ($product->comments as $comment) {
                    Comment::find($comment->id)->delete();
                }

                $image = $product->image;
                $images = $product->images;

                if(is_file(str_replace('\\', '/', public_path("uploads/$image")))) {
                    unlink(str_replace('\\', '/', public_path("uploads/$image")));
                }

                foreach ($images as $v) {
                    if(is_file(str_replace('\\', '/', public_path("uploads/$v->image")))) {
                        unlink(str_replace('\\', '/', public_path("uploads/$v->image")));
                    }
                }

                $product->delete();
            }
        }
    }
}
