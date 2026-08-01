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
Schema::create('bingo_cards', function (Blueprint $table) {

    $table->id();

    $table->foreignId('game_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->foreignId('user_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->json('numbers');

    $table->string('card_hash');

    $table->boolean('is_winner')
        ->default(false);

    $table->timestamps();

    // One card per user per game
    $table->unique(['game_id', 'user_id']);

    // Prevent duplicate cards in the same game
    $table->unique(['game_id', 'card_hash']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bingo_cards');
    }
};
