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
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'task_user');
    }
}
