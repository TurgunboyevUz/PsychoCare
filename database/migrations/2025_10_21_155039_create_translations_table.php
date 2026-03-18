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
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('group')->index(); // e.g., 'messages', 'validation'
            $table->string('key')->index(); // e.g., 'start', 'welcome'
            $table->string('locale', 10)->index(); // e.g., 'uz', 'en', 'ru'
            $table->text('value');
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->unique(['group', 'key', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
