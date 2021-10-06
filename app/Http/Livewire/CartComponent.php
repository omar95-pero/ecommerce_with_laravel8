<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Cart;

class CartComponent extends Component
{
    public function increaseQty($rowId)
    {
        $product = Cart::get($rowId);
        $qty = $product->qty + 1;
        Cart::update($rowId, $qty);
    }
    public function decreaseQty($rowId)
    {
        $product = Cart::get($rowId);
        $qty = $product->qty - 1;
        Cart::update($rowId, $qty);
    }
    public function destroy($rowId)
    {
        Cart::remove($rowId);
        session()->flash('success_message', 'The Item has been removed');
    }
    public function deleteAll()
    {
        Cart::destroy();
        session()->flash('success_message', 'The Items has been removed');
    }
    public function render()
    {
        return view("livewire.cart-component")->layout("layouts.base");
    }
}
