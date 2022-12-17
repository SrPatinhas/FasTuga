<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
            'name',
            'type',
            'description',
            'photo_url',
            'price',
            'custom',
    ];

    //aquiii
    public function owner()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class,'delivered_by');
    }

    public function orders()
    {
        return $this->hasManyThrough(
            Order::class,
            OrderItem::class,
            'order_id', // Foreign key on OrderItem table
            'id', // Local key on Order table
            'id', // Local key on orders table
            'product_id' // Foreign key on OrderItem table
        );
    }
}
