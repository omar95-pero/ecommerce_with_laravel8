<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;

class ShopComponent extends Component
{
    public $sorting;
    public $pagesSize;
    public function mount()
    {
        $this->sorting = 'default';
        $this->pagesSize = 12;
    }
    public function store($product_id, $product_name, $product_price)
    {
        Cart::add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');
        session()->flash('success_message', 'Item Added Success');
        return redirect()->route('product.cart');
    }
    use WithPagination;
    public function render()
    {
        if ($this->sorting === 'date') {
            $products = Product::orderBy('created_at', 'DESC')->paginate($this->pagesSize);
        } elseif ($this->sorting === 'price') {
            $products = Product::orderBy('price', 'ASC')->paginate($this->pagesSize);
        } elseif ($this->sorting === 'price-desc') {
            $products = Product::orderBy('price', 'DESC')->paginate($this->pagesSize);
        } else {
            $products = Product::paginate($this->pagesSize);
        }
        return view('livewire.shop-component', ['products' => $products])->layout('website.layouts.base');
    }
}
