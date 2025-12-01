<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'meal_id',
        'meal_name',
        'meal_price',
        'quantity',
        'subtotal',
        'special_instructions',
    ];

    protected $casts = [
        'meal_price' => 'decimal:2',
        'quantity' => 'integer',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Relationships
     */
    
    // Order item belongs to an order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Order item belongs to a meal
    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    /**
     * Helper Methods
     */
    
    // Get formatted subtotal
    public function getFormattedSubtotalAttribute()
    {
        return '$' . number_format($this->subtotal, 2);
    }

    // Get formatted price
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->meal_price, 2);
    }
}