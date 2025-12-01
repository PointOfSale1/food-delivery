<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'name',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Relationships
     */
    
    // Category belongs to a restaurant
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    // Category has many meals
    public function meals()
    {
        return $this->hasMany(Meal::class);
    }

    /**
     * Helper Methods
     */
    
    // Get active meals in this category
    public function activeMeals()
    {
        return $this->meals()->where('is_available', true)->orderBy('sort_order')->get();
    }

    // Count meals in category
    public function mealsCount()
    {
        return $this->meals()->count();
    }
}