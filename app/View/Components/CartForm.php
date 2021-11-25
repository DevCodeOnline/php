<?php

namespace App\View\Components;

use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class CartForm extends Component
{
    public $id;
    /**
     * Create a new component instance.
     *
     * @param $id
     *
     * @return void
     */
    public function __construct($id = 1)
    {
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $delivery = Delivery::find($this->id);
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
        return view('components.cart-form', compact('delivery','calc', 'calcDelivery'));
    }

    public function update(Request $request)
    {
        $this->id =  $request->id;
        return $this->render();
    }
}
