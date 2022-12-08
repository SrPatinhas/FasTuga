<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'ticket,number',
        'status',
        'customer_id',
        'total_price',
        'total_paid',
        'total_paid_with_points',
        'points_gained',
        'payment_type',
        'payment_reference',
        'date',
        'delivered_by',
        'custom',

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
    //aquiii 
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
}
