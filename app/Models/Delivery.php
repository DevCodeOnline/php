<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = ['title'];
    public $timestamps = false;

    public function payments()
    {
        return $this->belongsToMany(Payment::class);
    }

    public function region()
    {
        return $this->belongsToMany(Region::class)->withPivot('days', 'value', 'percent', 'status');
    }

    public function notRegion()
    {
        return $this->belongsToMany(Delivery::class, 'delivery_not_region')->withPivot('title');
    }
}
