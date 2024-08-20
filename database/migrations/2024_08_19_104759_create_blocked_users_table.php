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
        Schema::create('blocked_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blocker_id'); // ID of the user who blocks another user
            $table->foreignId('blocked_user_id'); // ID of the blocked user
            $table->foreignId('blocked_room_id')->nullable(); // ID of the blocked room (nullable for app-wide block)
            $table->dateTime('block_start_date')->nullable(); // The date when the block starts
            $table->dateTime('block_end_date')->nullable(); // The date when the block ends (null for permanent block)
            $table->enum('block_type', ['app', 'room']); // Type of block (app-wide or room-specific)
            $table->boolean('is_unblocked')->default(false); // Indicates if the block has been removed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocked_users');
    }
};
