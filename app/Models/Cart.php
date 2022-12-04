<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [];

    const CART_TYPE_DEFAULT = 0;
    const CART_TYPE_WISHLIST = 1;

    const ALL_CART_TYPES = [
        self::CART_TYPE_DEFAULT,
        self::CART_TYPE_WISHLIST,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getGrandTotalAttribute()
    {
        return $this->cartItems->sum('subtotal');
    }
}
