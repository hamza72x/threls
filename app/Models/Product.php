<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    const PAGINATE_ITEMS = 15;

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
