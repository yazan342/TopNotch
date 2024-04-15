<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const STATUS_PENDING = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_SOLD = 2;



    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'quantity',
        'category_id',
        'genderCategory_id',
        'seller_id',
        'status',
    ];

    public function getStatusText()
    {
        switch ($this->status) {
            case self::STATUS_PENDING:
                return 'Pending';
            case self::STATUS_ACCEPTED:
                return 'Accepted';
            case self::STATUS_SOLD:
                return 'sold';
            default:
                return 'Unknown';
        }
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function genderCategory()
    {
        return $this->belongsTo(GenderCategory::class, 'genderCategory_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }


    public function review()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class, 'product_id');
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'product_id');
    }
    public function orders()
    {
        return $this->hasManyThrough(Order::class, CartProduct::class);
    }
}
