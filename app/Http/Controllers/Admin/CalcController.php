<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalcController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        DB::table('payment_calc')->where('id', 1)->update(['calc' => $request->input('calc')]);
        $request->session()->flash('success', 'Расчет изменен');
        return redirect()->route('payments.index');
    }

    public function delivery(Request $request)
    {
        DB::table('delivery_calc')->where('id', 1)->update(['calc' => $request->input('calc')]);
        $request->session()->flash('success', 'Расчет изменен');
        return redirect()->route('deliveries.index');
    }
}
