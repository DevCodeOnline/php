<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'value', 'percent'];
    public $timestamps = false;

    public function delivery()
    {
        return $this->belongsToMany(Delivery::class);
    }

}
