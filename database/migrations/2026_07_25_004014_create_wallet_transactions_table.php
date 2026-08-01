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
       Schema::create('wallet_transactions', function (Blueprint $table) {

    $table->id();

    $table->foreignId('wallet_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->foreignId('user_id')
        ->constrained()
        ->cascadeOnDelete();

    // Related game (optional)
    $table->foreignId('game_id')
        ->nullable()
        ->constrained()
        ->nullOnDelete();

    $table->enum('type', [
        'deposit',
        'withdraw',
        'ticket_purchase',
        'winning',
        'refund',
        'bonus'
    ]);

    $table->decimal('amount', 12, 2);

    $table->decimal('balance_before', 12, 2);

    $table->decimal('balance_after', 12, 2);

    $table->string('reference')->unique();

    $table->text('description')->nullable();

    $table->enum('status', [
        'pending',
        'completed',
        'failed'
    ])->default('completed');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
