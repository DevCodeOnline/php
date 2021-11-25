<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image', 'content'];
    public $timestamps = false;

    public function getImage()
    {
        if (!$this->image) {
            return asset("no-image.png");
        }
        return asset("uploads/data/{$this->image}");
    }
}
