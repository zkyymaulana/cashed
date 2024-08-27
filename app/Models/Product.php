<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'image', 'price', 'active', 'stock', 'discount']; // Tambahkan stock dan discount

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderDetails()
{
    return $this->hasMany(OrderDetail::class);
}
}
