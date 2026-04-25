<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        "user_id",
        "product_id",
        "viewed",
        "incart",
        "purchased",
        "rating",
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
