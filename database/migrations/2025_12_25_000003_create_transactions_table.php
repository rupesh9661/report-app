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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->foreignId('provider_id')->constrained('providers')->onDelete('cascade');
            $table->string('transaction_code')->unique();
            $table->decimal('amount', 15, 2);
            $table->string('status'); // success, failed, pending, cancelled
            $table->string('type')->nullable(); // bet, win, refund
            $table->text('description')->nullable();
            $table->timestamp('transaction_date');
            $table->timestamps();
            
            // Indexes for efficient filtering
            $table->index('user_id');
            $table->index('game_id');
            $table->index('provider_id');
            $table->index('status');
            $table->index('transaction_date');
            $table->index(['transaction_date', 'status']);
            $table->index(['user_id', 'status']);
            $table->index('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
