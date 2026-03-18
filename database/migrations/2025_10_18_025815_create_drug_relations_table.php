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
        Schema::create('drug_relations', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['switch_antidepressants', 'switch_antipsychotics', 'combine_moodstabilizers', 'stop_antidepressants', 'lactation', 'interaction']);
            
            $table->foreignId('primary_drug_id')->nullable()->constrained('drugs')->cascadeOnDelete();
            $table->foreignId('secondary_drug_id')->nullable()->constrained('drugs')->cascadeOnDelete();
            $table->string('drug_list')->nullable(); // interaction uchun
            
            $table->json('metadata')->nullable();
            
            $table->timestamps();
            
            $table->index(['type', 'primary_drug_id']);
            $table->index('secondary_drug_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drug_relations');
    }
};
