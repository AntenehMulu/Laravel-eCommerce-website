<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class ProductsPage extends Component
{
    use LivewireAlert;
    use WithPagination;

    #[Url]
    public  $selected_category=[];

    #[Url]
    public $selected_brands=[];

    #[Url]
    public $is_featured;

    #[Url]
    public $on_sale;

    #[Url]
    public $price_range =300000;

    #[Url]
    public $sort ='latest';

    public function addToCart($product_id){
        $total_count = CartManagement::addItemToCart($product_id);
        $this->dispatch('update-cart-count', total_count:$total_count)->to(Navbar::class);
        $this->alert('success', 'Product added to the cart successfully!', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
           ]);
    }


    public function render()
    {
        $proudctquery = Product::query()->where('is_active',1);

        if(!empty($this->selected_category)){
            $proudctquery->whereIn('category_id', $this->selected_category);
        }

        if(!empty($this->selected_brands)){
            $proudctquery->whereIn('brand_id', $this->selected_brands);
        }

        if ($this->is_featured) {
            $proudctquery->where('is_featured', 1);
        }

        if ($this->on_sale) {
            $proudctquery->where('on_sale', 1);
        }
        if($this->price_range){
            $proudctquery->whereBetween('price',[0, $this->price_range]);
        }
        if($this->sort == 'latest'){
            $proudctquery->latest();
        }
        if($this->sort == 'price'){
            $proudctquery->orderBy('price');
        }


        $categories=Category::query()->where('is_active',1)->get(['id','name','slug']);
        $brands=Brand::query()->where('is_active',1)->get(['id','name','slug']);
        return view('livewire.products-page',[
            'products'=>$proudctquery->paginate(9),
            'categories'=>$categories,
            'brands'=>$brands]);
    }
}
