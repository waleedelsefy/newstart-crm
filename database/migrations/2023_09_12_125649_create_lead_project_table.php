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
        Schema::create('lead_project', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('project_id')->nullable()->constrained('projects', 'id')->cascadeOnUpdate()->nullOnDelete();
            $table->string('project_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_project');
    }
};
