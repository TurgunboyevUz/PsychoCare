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
        Schema::create('broadcasts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('content');
            $table->string('image', 300)->nullable();
            $table->boolean('in_top')->default(false);

            $table->json('buttons')->nullable();
            $table->boolean('notification')->default(true); // disable_notification

            $table->unsignedBigInteger('sent')->default(0);
            $table->unsignedBigInteger('failed')->default(0);

            $table->enum('status', ['pending', 'processing', 'cancelled', 'failed', 'completed'])->default('pending');
            $table->timestamp('scheduled_at')->nullable(); // null for start now
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('broadcasts');
    }
};
