<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [

        'order_id',
        'order_local_number',
        'product_id',
        'status',
        'price',
        'preparation_by',
        'notes',
        'custom',

    ];

    // W "Waiting", P "Preparing", R "Ready"
    public function getStatusNameAttribute()
    {
        switch ($this->status) {
            case 'W':
                return 'Waiting';
            case 'P':
                return 'Preparing';
            case 'R':
                return 'Ready';
        }
    }


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








    

}
