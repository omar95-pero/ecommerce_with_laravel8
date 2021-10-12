<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;
use App\Models\Category;

class CategoryComponent extends Component
{
    public $sorting;
    public $pagesSize;
    public $categorr_slug;
    public function mount($categorr_slug)
    {
        $this->sorting = 'default';
        $this->pagesSize = 12;
        $this->categorr_slug = $categorr_slug;
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
        $category = Category::where('slug', $this->categorr_slug)->first();
        $category_id = $category->id;
        $category_name = $category->name;
        if ($this->sorting === 'date') {
            $products = Product::where('category_id', $category_id)->orderBy('created_at', 'DESC')->paginate($this->pagesSize);
        } elseif ($this->sorting === 'price') {
            $products = Product::where('category_id', $category_id)->orderBy('price', 'ASC')->paginate($this->pagesSize);
        } elseif ($this->sorting === 'price-desc') {
            $products = Product::where('category_id', $category_id)->orderBy('price', 'DESC')->paginate($this->pagesSize);
        } else {
            $products = Product::where('category_id', $category_id)->paginate($this->pagesSize);
        }
        $categories = Category::all();
        return view('livewire.category-component', ['products' => $products, 'categories' => $categories, 'category_name' => $category_name])->layout('website.layouts.base');
    }
}
