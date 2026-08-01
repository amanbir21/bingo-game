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
        Schema::create('games', function (Blueprint $table) {

            $table->id();

            // Unique game identifier (e.g. BG-20260725-0001)
            $table->string('game_code')->unique();

            // Game name
            $table->string('title');

            // Optional description
            $table->text('description')->nullable();


          


            // Ticket price
            $table->decimal('ticket_price', 12, 2);

            // Percentage of ticket sales awarded as prizes
            $table->decimal('prize_percentage', 5, 2)
                ->default(80.00);

            // Player limits
            $table->unsignedInteger('minimum_players')
                ->default(10);

            $table->unsignedInteger('maximum_players')
                ->default(100);

            // Seconds between number draws
            $table->unsignedTinyInteger('draw_interval')
                ->default(5);

            // Game status
            $table->enum('status', [
                'draft',
                'waiting',
                'running',
                'finished',
                'cancelled'
            ])->default('draft');


            // Winner information
            $table->foreignId('winner_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();


            // Final prize paid to winner(s)
            $table->decimal('final_prize', 12, 2)
                ->default(0);


            // Total ticket sales
            $table->decimal('total_sales', 12, 2)
                ->default(0);


            // Number of tickets sold
            $table->unsignedInteger('tickets_sold')
                ->default(0);


            // Game start/end times
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();


            // Admin who created the game
            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();


            $table->timestamps();


            // Indexes
            $table->index('status');
            $table->index('started_at');

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};