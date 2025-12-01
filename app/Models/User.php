<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'city',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relationships
     */
    
    // User has many orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Helper Methods
     */
    
    // Get user's recent orders
    public function recentOrders($limit = 5)
    {
        return $this->orders()->latest()->limit($limit)->get();
    }

    // Get total orders count
    public function totalOrders()
    {
        return $this->orders()->count();
    }

    // Get total spent
    public function totalSpent()
    {
        return $this->orders()->where('status', 'delivered')->sum('total');
    }
    
}