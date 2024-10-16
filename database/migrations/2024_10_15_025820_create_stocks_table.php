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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('symbol'); // Stock symbol (e.g., MSFT, GOOGL, AAPL)
            $table->timestamp('timestamp'); // Timestamp of the data point
            $table->decimal('open', 15, 6); // Open price
            $table->decimal('high', 15, 6); // High price
            $table->decimal('low', 15, 6); // Low price
            $table->decimal('close', 15, 6); // Close price
            $table->decimal('previous_close', 15, 6)->nullable(); // Previous close price
            $table->bigInteger('volume'); // Trading volume
            $table->timestamps(); // Laravel timestamps (created_at, updated_at)
            
            // Add a unique constraint to prevent duplicate entries for the same symbol and timestamp
            $table->unique(['symbol', 'timestamp']);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};





