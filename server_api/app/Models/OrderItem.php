<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'order_local_number',
        'product_id',
        'product_quantity',
        'status',
        'price',
        'preparation_by',
        'notes',
        'custom',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'preparation_by');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
