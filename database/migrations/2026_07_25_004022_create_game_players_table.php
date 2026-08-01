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
      Schema::create('game_players', function (Blueprint $table) {

    $table->id();

    $table->foreignId('game_id')
        ->constrained('games')
        ->cascadeOnDelete();

    $table->foreignId('user_id')
        ->constrained('users')
        ->cascadeOnDelete();


    $table->string('ticket_number')->unique();


    $table->decimal('ticket_price',12,2);


    $table->enum('status',[
        'joined',
        'playing',
        'winner',
        'left',
        'disqualified'
    ])->default('joined');


    $table->boolean('prize_paid')
        ->default(false);


    $table->timestamp('joined_at');


    $table->timestamps();


    $table->unique([
        'game_id',
        'user_id'
    ]);

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_players');
    }
};