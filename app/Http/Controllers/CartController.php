<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Delivery;
use App\Models\Information;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use YaGeo;

class CartController extends Controller
{
    public function index()
    {
        $count = session()->has('cart');
        $payments = Payment::all();

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

        $code = null;
        $codes = Information::where('title', 'Api')->get();
        foreach ($codes->pluck('content') as $cods) {
            $code = $cods;
        }

        return view('shop.cart', compact('count', 'payments', 'calc', 'code', 'calcDelivery'));
    }


    public function addCart($id, Request $request)
    {
        $product = Product::find($id);
        $cart = $request->session()->get('cart');

        if (!$request->session()->has('cart')) {
            session(['cart' => [
                $product->id => ['id' => $product->id, 'title' => $product->title, 'slug' => $product->slug, 'img' => $product->getImage(), 'price' => $product->price, 'qnt' => 1]
            ]]);
        } else {
            if (array_key_exists($product->id, $cart)) {
                foreach ($request->session()->get('cart') as $k => $v) {
                    if ($v['id'] == $product->id) {
                        $request->session()->put("cart.$k.qnt", $v['qnt'] + 1);
                    }
                }
            } else {
                $request->session()->put("cart.$product->id", ['id' => $product->id, 'title' => $product->title, 'slug' => $product->slug, 'img' => $product->getImage(), 'price' => $product->price, 'qnt' => 1]);
            }

        }

    }

    public function countCart()
    {
        return count(session()->get('cart'));
    }

    public function order(Request $request)
    {
        $product_id = [];

        // Получаем id товаров
        foreach ($request->input('products') as $product) {
            array_push($product_id, $product['id']);
        }

        // Получаем товары по id
        $products = Product::whereIn('id', $product_id)->get();

        // Получаем товары у которых количество = 0
        $product_not = $products->where('quantity', 0);

        //Проверяем есть ли товары в таком количество
        $product_qnt = [];

        foreach ($request->input('products') as $item) {
            $product_ony = Product::find($item['id']);
            if ($product_ony->quantity < (int)$item['qnt']) {
                array_push($product_qnt, $product_ony);
            }
        }

        // Получаем пользователя
        $info = Information::where('title', 'E-mail-логин')->first();

        // Записываем все данные в переменную
        $data = $request->all();

        //Если количество товара = 0
        if ($product_not && $product_not->count()) {
            Mail::to($info->content)->send(new OrderMail($data, 0));
            return response()->json(['errors' => $product_not], 424);
        }

        //Если количество товаров не хватает
        if ($product_qnt) {
            Mail::to($info->content)->send(new OrderMail($data, 0));
            return response()->json(['errors' => $product_qnt], 423);
        }

        // Валидация
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'adress' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);

        Mail::to($info->content)->send(new OrderMail($data, 1));

        foreach ($request->input('products') as $item) {
            $v = Product::find($item['id']);
            $qnt = $v->quantity;
            $decrement = $item['qnt'];
            $v->quantity = $qnt - $decrement;
            $v->save();
        }

        $request->session()->forget('cart');

        $request->session()->flash('success', 'Заказ оформлен');

        return true;
    }

}
