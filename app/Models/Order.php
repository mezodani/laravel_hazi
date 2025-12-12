<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use function Symfony\Component\String\b;

class Order extends Model
{
    protected $fillable = ["name", "user_id"];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function products() {
        return $this->belongsToMany(Product::class, "order_product")
            ->withPivot("quantity")
            ->withTimestamps();
    }
}
