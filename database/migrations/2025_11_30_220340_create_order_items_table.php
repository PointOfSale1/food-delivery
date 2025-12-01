<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('meal_id')->constrained()->onDelete('cascade');
            
            // Store meal details at time of order (in case meal changes later)
            $table->string('meal_name');
            $table->decimal('meal_price', 10, 2);
            $table->integer('quantity');
            $table->decimal('subtotal', 10, 2); // price * quantity
            
            $table->text('special_instructions')->nullable();
            $table->timestamps();
            
            // Index
            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};