<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class  Customer extends Model
{
    use HasFactory,SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'phone',
        'points',
        'nif',
        'default_payment_type',
        'default_payment_reference',
        'custom'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

     public function orders()
     {
         return $this->hasMany(Order::class, 'customer_id');
     }
}
