<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';

    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class, 'cart_id');
    }
    public function order()
    {
        return $this->hasOne(Order::class, 'cart_id');
    }
}
