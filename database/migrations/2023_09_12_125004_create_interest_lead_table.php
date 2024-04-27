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
        Schema::create('interest_lead', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('interest_id')->nullable()->constrained('interests', 'id')->cascadeOnUpdate()->nullOnDelete();
            $table->string('interest_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interest_lead');
    }
};
