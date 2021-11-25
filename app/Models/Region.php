<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Region extends Model
{
    use HasFactory;

    protected $fillable = ['title'];
    public $timestamps = false;

    public function getCoords()
    {
        $geoCoder = Http::get("https://geocode-maps.yandex.ru/1.x/?format=json&apikey=c991704e-3011-4b84-b8ee-bb14d7dfd93f&geocode=$this->title")
        ['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];

        $data = explode(' ', $geoCoder);

        list($data[0], $data[1]) = array($data[1], $data[0]);

        return implode($data, ', ');
    }

    public function delivery()
    {
        return $this->belongsToMany(Delivery::class, 'delivery_region');
    }
}
