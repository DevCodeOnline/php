<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Payment;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $calc = DB::table('payment_calc')->pluck('calc')->first();

        $payments = Payment::paginate(25);
        return view('admin.payments.index', compact('payments', 'calc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $payments = Payment::pluck('title', 'id');
        $deliveries = Delivery::pluck('title', 'id');
        return view('admin.payments.create', compact('payments', 'deliveries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $payment = Payment::create($request->all());

        $payment->status = $request->input('status');
        $payment->save();

        $payment->delivery()->sync($request->deliveries);

        $request->session()->flash('success', 'Способ оплаты добавлена');

        return redirect()->route('payments.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = Payment::find($id);
        $deliveries = Delivery::pluck('title', 'id');
        return view('admin.payments.edit', compact('payment', 'deliveries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $payment = Payment::find($id);

        $payment->update($request->all());

        $payment->status = $request->input('status');
        $payment->save();

        $payment->delivery()->sync($request->deliveries);

        $request->session()->flash('success', 'Способ оплаты обновлен');

        return redirect()->route('payments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);
        $payment->delete();

        return redirect()->route('payments.index')->with('success', 'Способ оплаты удален');
    }
}
