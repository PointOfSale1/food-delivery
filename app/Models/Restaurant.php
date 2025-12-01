<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Restaurant extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'city',
        'description',
        'logo',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Automatically hash password when setting
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Relationships
     */
    
    // Restaurant has many categories
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    // Restaurant has many meals
    public function meals()
    {
        return $this->hasMany(Meal::class);
    }

    // Restaurant has many orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Helper Methods
     */
    
    // Get active categories
    public function activeCategories()
    {
        return $this->categories()->where('is_active', true)->orderBy('sort_order')->get();
    }

    // Get available meals
    public function availableMeals()
    {
        return $this->meals()->where('is_available', true)->get();
    }

    // Get pending orders count
    public function pendingOrdersCount()
    {
        return $this->orders()->where('status', 'pending')->count();
    }

    // Get today's orders
    public function todaysOrders()
    {
        return $this->orders()->whereDate('created_at', today())->get();
    }
}