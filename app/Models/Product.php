<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['id', 'title', 'description', 'quantity', 'price', 'image', 'sort'];
    public $timestamps = true;
    public $incrementing = false;
    public $keyType = 'string';

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function best()
    {
        return $this->belongsToMany(Product::class, 'best_product', 'product_id', 'best_id');
    }

    public function comments()
    {
        return $this->belongsToMany(Comment::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getImage()
    {
        if (!$this->image) {
            return asset("uploads/product/no-image.png");
        }
        return asset("uploads/{$this->image}");
    }
}
