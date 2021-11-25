<?php

namespace App\View\Components;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class DeliveryMethods extends Component
{
    public $payment;
    /**
     * Create a new component instance.
     *
     * @param $payment
     *
     * @return void
     */
    public function __construct($payment = 1)
    {
        $this->payment = $payment;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
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
        $deliveries = Payment::find($this->payment)->delivery;
        return view('components.delivery-methods', compact('deliveries', 'calc', 'calcDelivery'));
    }

    public function updateDelivery(Request $request)
    {
        $this->payment =  $request->id;
        return $this->render();
    }
}
