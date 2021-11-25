<?php

namespace App\Imports;

use App\Jobs\ImportBestProduct;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsUpdate implements ToCollection, SkipsOnError, SkipsEmptyRows, WithHeadingRow
{

    use SkipsErrors;

    public function collection(Collection $rows)
    {
        DB::table('jobs')->truncate();
        $max = Product::max('sort');
        $i = 1;
        if ($max) {
            $i += $max;
        }

        foreach ($rows as $row)
        {
            //Получаем изображение
            $images = explode(';', $row['images']);
            //Проверяем существует ли товара
            if ($product = Product::find($row['id_product'])) {

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

                $product->update([
                    'title'        => $row['title'],
                    'description'  => $row['description'],
                    'quantity'     => $row['quantity'],
                    'price'        => $row['price'],
                    'image'        => $images[0],
                ]);

                $product->categories()->detach();

                Image::where('product_id', $product->id)->delete();


                foreach ($product->comments as $item) {
                    Comment::find($item->id)->delete();
                }

                $product->comments()->detach();

                $product->best()->detach();
            } else {
                //Созддаем товар
                $product = Product::create([
                    'id'           => $row['id_product'],
                    'title'        => $row['title'],
                    'description'  => $row['description'],
                    'quantity'     => $row['quantity'],
                    'price'        => $row['price'],
                    'image'        => $images[0],
                    'sort'         => $i,
                ]);
                $i++;

            }

            //endforeach

            // Получаем все категории
            $categories = Category::all()->whereIn('title', explode(';', $row['categories']));

            // Добавляем категории к товару
            if ($categories) {
                foreach ($categories as $k => $v) {
                    $product->categories()->attach($v->id);
                }
            }

            //Добавляем изображение
            if ($images) {
                $images = array_slice($images, 1);
                foreach ($images as $image) {
                    Image::create(['product_id' => $product->id, 'image' => $image]);
                }
            }

            //Получаем отзывы делитель '|'

            $reviews = explode('|', $row['reviews']);

            //Добавляем отзывы
            if ($reviews) {
                foreach ($reviews as $review) {
                    $comment = Comment::create(['content' => $review]);
                    $product->comments()->attach($comment->id);
                }
            }

            //Получаем лучшие товары
            $bests = explode(';', $row['best']);
            if ($bests) {
                ImportBestProduct::dispatch($product, $bests);
            }

        }
    }
}
