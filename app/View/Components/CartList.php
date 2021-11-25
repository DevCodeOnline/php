<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CartList extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $products = session()->get('cart');
        return view('components.cart-list', compact('products'));
    }

    public function destroy($id)
    {

        session()->pull("cart.$id");
        if (empty(session()->get('cart'))) {
            session()->forget('cart');
        }

        return $this->render();
    }
}
