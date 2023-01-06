<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'ticket_number',
        'status',
        'customer_id',
        'total_price',
        'total_paid',
        'total_paid_with_points',
        'points_gained',
        'points_used_to_pay',
        'payment_type',
        'payment_reference',
        'date',
        'delivered_by',
        'custom',
        'notes',
        'created_at',
        'updated_at'
    ];

    // P "Preparing", R "Ready", D "Delivered", C "Cancelled"
    public function getStatusNameAttribute()
    {
        switch ($this->status) {
            case 'P':
                return 'Preparing';
            case 'R':
                return 'Ready';
            case 'D':
                return 'Delivered';
            case 'C':
                return 'Cancelled';
        }
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function responsible()
    {
        return $this->belongsTo(User::class, 'delivered_by');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            OrderItem::class,
            'order_id', // Foreign key on OrderItem table
            'id', // Local key on products table
            'id', // Local key on orders table
            'product_id' // Foreign key on OrderItem table
        );
    }
    /*
     * This will be used like
     *
     * Order::where(...)->ordersPreparing()->get()
     */
    public function scopeOrdersPreparing($query)
    {
        return $query->where('status', '=', 'P');
    }
    public function scopeOrdersReady($query)
    {
        return $query->where('status', '=', 'R');
    }
    public function scopeOrdersDelivered($query)
    {
        return $query->where('status', '=', 'D');
    }
    public function scopeOrdersCancelled($query)
    {
        return $query->where('status', '=', 'C');
    }
}
