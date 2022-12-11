<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

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


    //aquiii

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function getTotalTasksAttribute()
    {
        return Task::where('project_id', $this->id)->count();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }







 //cust
 public function user()
 {
     return $this->belongsTo(User::class);
 }

 public function orders()
 {
     return $this->hasMany(Order::class);
 }



}
