<?php

namespace App\View\Components;

use App\Models\Delivery;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class CartData extends Component
{
    public $delivery;
    public $city;
    public $count;
    /**
     * Create a new component instance.
     *
     * @param $delivery
     * @param  $city
     * @param  $count
     *
     * @return void
     */
    public function __construct($delivery = 1, $city = 'Санкт-Петербург', $count = null)
    {
        $this->delivery = $delivery;
        $this->city = $city;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // Получаем все регионы
        $region_title = Region::all()->pluck('title')->toArray();

        //Получаем способ доставки
        $delivery = Delivery::find($this->delivery);

        //Получаем доступные регионы для данного способа доставки
        $regions = $delivery->region->pluck('title')->toArray();

        $not_regions = [];

        //Добавляем исключания (город) - в массив
        foreach ($delivery->notRegion as $item) {
            array_push($not_regions, $item->pivot->title);
        }
        $delivery_method = null;
        if ($this->count == 1) {
            //Проверяем есть ли регион доставки для данного способа - если есть идем дальше, если нет входим в условие
            if (!Str::contains($this->city, $regions)) {

                $not_delivery_methods = [];
                // Запускам цикл по всем регионам
                foreach ($region_title as $title) {
                    // Проверяем есть ли такой регион во всех регионах - если нет идем дальше, если нет входим в условие
                    if (Str::contains($this->city, $title)) {
                        // Если такой регион есть в другом способе доставки записыываем регион в перменную
                        $delivery_method = Region::where('title', $title)->get()[0];
                    }
                }
                //Проверяем нашолся ли регион в других способах доставки
                if ($delivery_method) {
                    // Если нашлись проверяем - исключения


                    foreach ($delivery_method->delivery as $items) {
                        // $items - способы доставки

                        $no_regions = [];
                        // Получаем исключения для данного способа доставки

                        // Собираем массив исключений для данного метода
                        foreach ($items->notRegion->toArray() as $v) {
                            array_push($no_regions, $v['pivot']['title']);

                        }

                        //Проверяем есть ли исключения для данного адреса - если метод подходит записваем в массив
                        if (!Str::contains($this->city, $no_regions)) {
                            array_push($not_delivery_methods, $items->title);
                        }
                    }

                    //Если массив не пустов - передаем доступные методы
                    if ($not_delivery_methods) {
                        return response()->json(['error' => $not_delivery_methods], 421);
                    } else {
                        return response()->json(['error' => 'По данному адресу доставка отсутствует'], 422);
                    }

                } else {
                    return response()->json(['error' => 'По данному адресу доставка отсутствует'], 422);
                }
            }

            // Проверяем нет ли исключений для этого региона - если нет идем дальше, если есть входим в условие
            if (Str::contains($this->city, $not_regions)) {

                // Создаем переменную где будем хранить исключения
                $not_delivery_methods = [];

                // Проверяем есть ли такой регион в других способах доставки - если есть записываем в массив, если нет идем дальше
                foreach ($region_title as $title) {
                    if (Str::contains($this->city, $title)) {
                        $delivery_method = Region::where('title', $title)->get()[0];
                    }
                }

                //Проверяем нашолся ли регион в других способах доставки
                if ($delivery_method) {
                    // Если нашлись проверяем - исключения


                    foreach ($delivery_method->delivery as $items) {
                        // $items - способы доставки

                        $no_regions = [];
                        // Получаем исключения для данного способа доставки

                        // Собираем массив исключений для данного метода
                        foreach ($items->notRegion->toArray() as $v) {
                            array_push($no_regions, $v['pivot']['title']);

                        }

                        //Проверяем есть ли исключения для данного адреса - если метод подходит записваем в массив
                        if (!Str::contains($this->city, $no_regions)) {
                            array_push($not_delivery_methods, $items->title);
                        }
                    }

                    //Если массив не пустов - передаем доступные методы
                    if ($not_delivery_methods) {
                        return response()->json(['error' => $not_delivery_methods], 421);
                    } else {
                        return response()->json(['error' => 'По данному адресу доставка отсутствует'], 422);
                    }

                } else {
                    return response()->json(['error' => 'По данному адресу доставка отсутствует'], 422);
                }

            }
        }
        $price = 0;
        $days = 0;

        $calculator = DB::table('payment_calc')->pluck('calc');
        $calc = null;
        foreach ($calculator as $item) {
            $calc = $item;
        }

        $calculatorDelivery = DB::table('delivery_calc')->pluck('calc');
        $calcDelivery = null;
        foreach ($calculatorDelivery as $item) {
            $calcDelivery = $item;
        }

        foreach ($regions as $item) {
            if (Str::contains($this->city, $item)) {
                $days = $delivery->region->where('title', $item)->first()->pivot->days;
                if ($calcDelivery) {
                    $price = $delivery->region->where('title', $item)->first()->pivot->value;
                } else {
                    $price = $delivery->region->where('title', $item)->first()->pivot->percent;
                }
            }
        }

        return view('components.cart-data', compact('days', 'price', 'calc', 'calcDelivery'));
    }

    public function update(Request $request)
    {
        if ($request->city) {
            $this->city = $request->city;
        }

        if ($request->delivery) {
            $this->delivery = $request->delivery;
        }

        $this->count = 1;

        return $this->render();
    }
}
