<?php

namespace App\Livewire;

use App\Models\ActivityLog;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Computed;

class ViewCart extends Component
{
    public $user;
    public $cartItems;
    public function mount()
    {
        $this->cartItems = Product::whereHas("ActivityLog", function ($query) {
            $query->where("user_id", $this->user->id)->where("incart", 1);
        })->get();
    }
    public function buyAll()
    {
        $activity_logs =  ActivityLog::where("user_id", $this->user->id)
            ->whereIn("product_id", $this->cartItems->pluck("id"))->get();
        foreach ($activity_logs as $activity_log) {
            $activity_log->update([
                "purchased" => 1,
            ]);
        }
        session()->flash("purchased");
    }
    public function removeAll()
    {
        $activity_logs =  ActivityLog::where("user_id", $this->user->id)
            ->whereIn("product_id", $this->cartItems->pluck("id"))->get();
        foreach ($activity_logs as $activity_log) {
            $activity_log->update([
                "incart" => 0,
            ]);
        }
    }
    public function remove($id)
    {
        $activity_log =  ActivityLog::where("user_id", $this->user->id)
            ->where("product_id", $id)->first();
        $activity_log->update([
            "incart" => 0,
        ]);
    }
    public function render()
    {
        $this->cartItems = Product::whereHas("ActivityLog", function ($query) {
            $query->where("user_id", $this->user->id)->where("incart", 1);
        })->get();
        return view('livewire.view-cart');
    }
}
