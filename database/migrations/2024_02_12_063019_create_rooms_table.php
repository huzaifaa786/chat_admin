<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_id')->unique();
            $table->string('room_name')->nullable();
            $table->string('room_visibility')->nullable();
            $table->string('bulletin_message')->nullable();
            $table->string('host_id');
            $table->string('host_name')->nullable();
            $table->bigInteger('audience_count')->nullable();
            $table->string('room_type')->nullable();
            $table->foreignId('song_id')->nullable();
            $table->string('room_status')->default('live');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
