<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
        'price',
    ];
    public $timestamps = false;
    public function ActivityLog()
    {
        return $this->hasMany(ActivityLog::class);
    }
}
