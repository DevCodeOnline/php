<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = Information::all();
        $logo = $info->where('title', 'Логотип')[0];
        $about = $info->where('title', 'О нас')[2];
        $contact = $info->where('title', 'Контакты')[3];
        $payment = $info->where('title', 'Оплата и доставка')[4];
        $footer = $info->where('title', 'Подвал')[1];
        $api = $info->where('title', 'Api')[5];
        $favicon = $info->where('title', 'Favicon')[6];
        $login = $info->where('title', 'E-mail-логин')[7];

        return view('admin.informations.index', compact('logo', 'about', 'contact', 'payment', 'footer', 'api', 'favicon', 'login'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $info = Information::all();
        $logo = $info->where('title', 'Логотип')[0];
        $about = $info->where('title', 'О нас')[2];
        $contact = $info->where('title', 'Контакты')[3];
        $payment = $info->where('title', 'Оплата и доставка')[4];
        $footer = $info->where('title', 'Подвал')[1];
        $api = $info->where('title', 'Api')[5];
        $favicon = $info->where('title', 'Favicon')[6];
        $login = $info->where('title', 'E-mail-логин')[7];

        if ($request->hasFile('favicon')) {
            Storage::delete("data/$favicon->image");
            $name_favicon = $request->file('favicon')->getClientOriginalName();
            $request->file('favicon')->storeAs('data', $name_favicon);
            $favicon->image = $name_favicon;
            $favicon->save();
        }

        if ($request->hasFile('logo')) {
            Storage::delete("data/$logo->image");
            $name_logo = $request->file('logo')->getClientOriginalName();
            $request->file('logo')->storeAs('data', $name_logo);
            $logo->image = $name_logo;
            $logo->save();
        }

        if ($request->hasFile('about_image')) {
            Storage::delete("data/$about->image");
            $name_about = $request->file('about_image')->getClientOriginalName();
            $request->file('about_image')->storeAs('data', $name_about);
            $about->image = $name_about;
            $about->save();
        }

        $about->content = $request->input('about_content');
        $about->save();

        $contact->content = $request->input('contact_content');
        $contact->save();

        $payment->content = $request->input('payment_content');
        $payment->save();

        $footer->content = $request->input('footer_content');
        $footer->save();

        $api->content = $request->input('api_content');
        $api->save();

        $login->content = $request->input('email_login');
        $login->save();

        $request->session()->flash('success', 'Данные сайта изменены');

        return redirect()->route('informations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
