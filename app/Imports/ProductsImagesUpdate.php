<?php

namespace App\Imports;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImagesUpdate implements ToCollection, SkipsOnError, SkipsEmptyRows, WithHeadingRow
{

    use SkipsErrors;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            //Получаем товар
            $product = Product::where('id', $row['id_product'])->first();

            $imageOne = $product->image;
            $imagesAll = $product->images;

            if(is_file(str_replace('\\', '/', public_path("uploads/$imageOne")))) {
                unlink(str_replace('\\', '/', public_path("uploads/$imageOne")));
            }

            foreach ($imagesAll as $v) {
                if(is_file(str_replace('\\', '/', public_path("uploads/$v->image")))) {
                    unlink(str_replace('\\', '/', public_path("uploads/$v->image")));
                }
            }

            //Получаем изображение
            $images = explode(';', $row['images']);

            if (!empty($row['images'])) {
                $product->update([
                    'image' => $images[0],
                ]);
            }

            if (!empty($row['images'])) {
                Image::where('product_id', $product->id)->delete();

                //Добавляем изображение
                if ($images) {
                    $images= array_slice($images, 1);
                    foreach ($images as $image) {
                        if(!empty($image)) {
                            Image::create(['product_id' => $product->id, 'image' => $image]);
                        }
                    }
                }
            }

        }
    }
}
