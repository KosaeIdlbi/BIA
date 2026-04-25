<?php

namespace App\Livewire;

use App\Models\ActivityLog;
use Livewire\Component;

class ProductDetails extends Component
{
    public $user_id;
    public $product;
    public $incart;
    public $rating;
    protected $listeners = ["refresh"];
    public function refresh()
    {
        session()->flash("login_alert");
    }
    public function mount()
    {
        if ($this->user_id) {
            if (ActivityLog::where("user_id", $this->user_id)
                ->where("product_id", $this->product->id)->first()
            ) {
                ActivityLog::where("user_id", $this->user_id)
                    ->where("product_id", $this->product->id)->first()->update(["viewed" => 1]);
            } else {
                ActivityLog::create([
                    "user_id" => $this->user_id,
                    "product_id" => $this->product->id,
                    "viewed" => 1
                ]);
            }
            $this->incart = $this->product->ActivityLog->isNotEmpty() ? $this->product->ActivityLog[0]->incart : 0;
            $this->rating = $this->product->ActivityLog->isNotEmpty() ? $this->product->ActivityLog[0]->rating : 0;
        }
    }
    public function removeFromCart()
    {
        $activity_log = ActivityLog::where("user_id", $this->user_id)->where("product_id", $this->product->id)->first();
        if ($activity_log) {
            $activity_log->update([
                "incart" => 0
            ]);
        }
        $this->incart = 0;
    }
    public function addToCart()
    {
        if ($this->user_id) {
            $activity_log = ActivityLog::where("user_id", $this->user_id)->where("product_id", $this->product->id)->first();
            if ($activity_log) {
                $activity_log->update([
                    "incart" => 1,
                ]);
            } else {
                ActivityLog::create([
                    "user_id" => $this->user_id,
                    "product_id" => $this->product->id,
                    "incart" => 1,
                ]);
            }
            $this->incart = 1;
        } else {
            $this->dispatch("refresh");
        }
    }
    public function purchased()
    {
        if ($this->user_id) {
            $activity_log = ActivityLog::where("user_id", $this->user_id)->where("product_id", $this->product->id)->first();
            if ($activity_log) {
                $activity_log->update([
                    "purchased" => 1,
                ]);
            } else {
                ActivityLog::create([
                    "user_id" => $this->user_id,
                    "product_id" => $this->product->id,
                    "purchased" => 1,
                ]);
            }
            session()->flash("purchased");
        } else {
            $this->dispatch("refresh");
        }
    }
    public function deleteRating()
    {
        $activity_log = ActivityLog::where("user_id", $this->user_id)->where("product_id", $this->product->id)->first();
        if ($activity_log) {
            $activity_log->update([
                "rating" => 0
            ]);
        }
        $this->rating = 0;
    }
    public function rate($i)
    {
        if ($this->user_id) {
            $activity_log = ActivityLog::where("user_id", $this->user_id)->where("product_id", $this->product->id)->first();
            if ($activity_log) {
                $activity_log->update([
                    "rating" => $i,
                ]);
            } else {
                ActivityLog::create([
                    "user_id" => $this->user_id,
                    "product_id" => $this->product->id,
                    "rating" => $i,
                ]);
            }
            $this->rating = $i;
        } else {
            $this->dispatch("refresh");
        }
    }

    public function render()
    {
        return view('livewire.product-details');
    }
}
