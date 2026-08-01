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
        Schema::create('withdrawals', function (Blueprint $table) {

    $table->id();

    $table->foreignId('user_id')->constrained()->cascadeOnDelete();

    $table->foreignId('wallet_id')->constrained()->cascadeOnDelete();

    $table->foreignId('payment_method_id')->constrained()->cascadeOnDelete();

    $table->decimal('amount',12,2);

    $table->string('account_name');

    $table->string('account_number');

    $table->enum('status',[
        'pending',
        'approved',
        'rejected'
    ]);

    $table->foreignId('approved_by')->nullable()->constrained('users');

    $table->text('remarks')->nullable();

    $table->timestamp('requested_at')->nullable();

    $table->timestamp('approved_at')->nullable();

    $table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
