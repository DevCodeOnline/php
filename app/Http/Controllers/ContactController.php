<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Information::where('title', 'Контакты')->get();
        foreach ($contacts as $item) {
            $contact = $item;
        }

        return view('shop.contact', compact('contact'));
    }
}
