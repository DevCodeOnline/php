<?php

namespace App\Imports;

use App\Jobs\ImportBestProduct;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Throwable;

class ProductsImport implements ToCollection, SkipsOnError, SkipsEmptyRows, WithHeadingRow
{

    use SkipsErrors;

    public function collection(Collection $rows)
    {
        Product::query()->delete();
        Comment::query()->delete();
        DB::table('jobs')->truncate();
        foreach ($rows as $row)
        {
            //Получаем изображение
            $images = explode(';', $row['images']);

            //Созддаем товар
            $product = Product::create([
                'id'           => $row['id'],
                'title'        => $row['title'],
                'description'  => $row['description'],
                'quantity'     => $row['quantity'],
                'price'        => $row['price'],
                'image'        => $images[0],
            ]);

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
                $images= array_slice($images, 1);
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
