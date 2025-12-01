<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'category_id',
        'name',
        'description',
        'ingredients',
        'price',
        'image',
        'is_available',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Relationships
     */
    
    // Meal belongs to a restaurant
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    // Meal belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Meal appears in many order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Helper Methods
     */
    
    // Get full image URL
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return Storage::url($this->image);
        }
        return asset('images/no-image.png'); // Default image
    }

    // Format price with currency
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    // Check if meal is in stock
    public function isInStock()
    {
        return $this->is_available;
    }
}