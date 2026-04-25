<?php

namespace App\Livewire;

use App\Models\ActivityLog;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class ViewProducts extends Component
{
    public $user;
    protected $listeners = ["refresh", "refreshProducts"];
    public function refresh()
    {
        session()->flash("login_alert");
    }
    #[Computed()]
    public function products()
    {
        if ($this->user) {
            return Product::with(["ActivityLog" => function ($query) {
                $query->where("user_id", $this->user->id);
            }])->inRandomOrder()->take(4)->get();
        } else {
            return Product::inRandomOrder()->take(4)->get();
        }
    }
    public function refreshProducts()
    {
        return 0;
    }
    public function render()
    {
        return view('livewire.view-products', ["products" => $this->products, "count" => Product::count()]);
        // return view('livewire.view-products', ["products" => $this->products, "count" => Product::count(), "suggestions" => $this->suggestions]);
    }
}
