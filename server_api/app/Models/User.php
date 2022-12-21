<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


// Remove Sanctum Tokens
//use Laravel\Sanctum\HasApiTokens;
// Add Laravel Tokens
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'blocked',
        'photo_url',
        'custom',
    ];

    // C "Customer"; EC "Employee - Chef"; ED "Employee - Delivery"; EM "Employee - Manager";
    public function getTypeNameAttribute()
    {
        switch ($this->type) {
            case 'C':
                return 'Customer';
            case 'EC':
                return 'Employee - Chef';
            case 'ED':
                return 'Employee - Delivery';
            case 'EM':
                return 'Employee - Manager';
        }
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getGenderNameAttribute()
    {
        return $this->gender == 'M' ? 'Masculine' : 'Feminine';
    }


    public function customer()
    {
        return $this->hasOne(Customer::class, 'user_id');
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class, 'preparation_by');
    }

    public function delivering()
    {
        return $this->hasMany(Order::class, 'delivered_by');
    }

    public function getIsCustomer()
    {
        return $this->type == 'C';
    }

    
}


