<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $calc = DB::table('delivery_calc')->pluck('calc')->first();

        $deliveries = Delivery::paginate(25);
        return view('admin.deliveries.index', compact('deliveries', 'calc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $deliveries = Delivery::pluck('title', 'id');
        $regions = Region::pluck('title', 'id');
        return view('admin.deliveries.create', compact('deliveries', 'regions'));
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

        $data = $request->all();
        $data['not_regions'] = explode(';', $request->input('not_regions'));

        $delivery = Delivery::create($data);

        $delivery->status = $request->input('status');
        $delivery->save();

        foreach ($data['regions'] as $k => $v) {
            if ($v['add'] == 1) {
                Delivery::find($delivery->id)->region()->attach([
                    $k => ['days' => $v['days'], 'value' => $v['value'], 'percent' => $v['percent'], 'status' => '1'],
                ]);
            }
        }

        foreach ($data['not_regions'] as $k => $v) {
            Delivery::find($delivery->id)->notRegion()->attach([
                $k => ['title' => trim($v)],
            ]);
        }

        $request->session()->flash('success', 'Способ доставки добавлена');

        return redirect()->route('deliveries.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $delivery = Delivery::find($id);
        $regions = Region::pluck('title', 'id');

        $not_regions = [];
        foreach ($delivery->notRegion()->get()->toArray() as $item) {
            $not_regions[] = $item['pivot']['title'];
        }

        $not_regions = implode(';', $not_regions);

        return view('admin.deliveries.edit', compact('delivery', 'regions', 'not_regions'));
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

        $data = $request->all();
        $data['not_regions'] = explode(';', $request->input('not_regions'));

        $delivery = Delivery::find($id);
        $delivery->update($request->all());

        $delivery->status = $request->input('status');
        $delivery->save();

        $delivery->region()->detach();

        foreach ($data['regions'] as $k => $v) {
            if ($v['add'] == 1) {
                $delivery->region()->attach([
                    $k => ['days' => $v['days'], 'value' => $v['value'], 'percent' => $v['percent'], 'status' => '1'],
                ]);
            }
        }

        $delivery->notRegion()->detach();

        foreach ($data['not_regions'] as $k => $v) {
            if (!empty($v)) {
                Delivery::find($delivery->id)->notRegion()->attach([
                    $k => ['title' => trim($v)],
                ]);
            }
        }

        $request->session()->flash('success', 'Способ доставки изменен');

        return redirect()->route('deliveries.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delivery = Delivery::find($id);
        $delivery->delete();

        return redirect()->route('deliveries.index')->with('success', 'Способ доставки удален');
    }
}
