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
    Schema::create('drawn_numbers', function (Blueprint $table) {

    $table->id();

    $table->foreignId('game_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->string('column',1);

    $table->tinyInteger('number');

    $table->integer('draw_order');

    $table->timestamp('drawn_at');

    $table->timestamps();


    $table->unique([
        'game_id',
        'number'
    ]);

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drawn_numbers');
    }
};
