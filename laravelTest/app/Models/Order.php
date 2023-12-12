<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyerId',
        'productId',
        'quantity',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyerId');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId');
    }
}
