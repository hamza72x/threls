<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    const STATUS_PENDING = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_DECLINED = 3;

    public function getStatusNameAttribute()
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_DECLINED => 'Declined',
            default => 'Unknown',
        };
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
