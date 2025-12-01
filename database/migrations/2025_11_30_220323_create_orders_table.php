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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique(); // e.g., ORD-20240315-0001
            
            // Customer Information
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->text('delivery_address');
            $table->string('city')->nullable();
            $table->text('notes')->nullable();
            
            // Order Details
            $table->decimal('subtotal', 10, 2);
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            
            // Order Status
            $table->enum('status', [
                'pending',    // Just placed
                'confirmed',  // Restaurant accepted
                'preparing',  // Being prepared
                'ready',      // Ready for delivery
                'delivered',  // Completed
                'cancelled'   // Cancelled
            ])->default('pending');
            
            $table->enum('payment_method', ['cash', 'card'])->default('cash');
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
            
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['restaurant_id', 'status']);
            $table->index('order_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};