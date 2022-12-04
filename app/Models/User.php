<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use SebastianBergmann\Type\NullType;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'account_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const ACCOUNT_TYPE_ADMIN = 0;
    const ACCOUNT_TYPE_BUYER = 1;
    const ACCOUNT_TYPE_SELLER = 2;

    const ACCOUNT_TYPES = [
        self::ACCOUNT_TYPE_BUYER,
        self::ACCOUNT_TYPE_SELLER,
        self::ACCOUNT_TYPE_ADMIN,
    ];

    function getAccountTypeNameAttribute(): string
    {
        return match ($this->account_type) {
            self::ACCOUNT_TYPE_ADMIN => 'Admin',
            self::ACCOUNT_TYPE_BUYER => 'Buyer',
            self::ACCOUNT_TYPE_SELLER => 'Seller',
            default => 'Unknown',
        };
    }

    function isAdmin(): bool
    {
        return $this->account_type === self::ACCOUNT_TYPE_ADMIN;
    }

    function isSeller(): bool
    {
        return $this->account_type === self::ACCOUNT_TYPE_SELLER;
    }

    function isBuyer(): bool
    {
        return $this->account_type === self::ACCOUNT_TYPE_BUYER;
    }

    function products()
    {
        return $this->hasMany(Product::class);
    }

    // usually only for buyer
    function mainCart(): Cart | null
    {
        if ($this->isBuyer()) {
            return Cart::firstOrCreate([
                'user_id' => $this->id,
                'cart_type' => Cart::CART_TYPE_DEFAULT,
            ]);
        }
        return null;
    }
}
