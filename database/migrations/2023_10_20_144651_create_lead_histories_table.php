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
        Schema::create('lead_histories', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['event', 'assigned', 'not_assigned', 'created', 'updated'])->default('created');
            $table->json('info')->nullable();

            $table->foreignId('branch_id')->nullable()->constrained('branches', 'id')->cascadeOnUpdate()->nullOnDelete();

            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('lead_id')->nullable()->constrained('leads')->cascadeOnUpdate()->nullOnDelete();

            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->cascadeOnUpdate()->nullOnDelete();

            $table->foreignId('event_id')->nullable()->default(1)->constrained('events', 'id')->cascadeOnUpdate()->nullOnDelete();
            $table->string('event_name')->default('fresh');
            $table->foreignId('previous_event')->nullable()->default(1)->constrained('events', 'id')->cascadeOnUpdate()->nullOnDelete();

            $table->foreignId('assigned_by')->nullable()->constrained('users', 'id')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users', 'id')->cascadeOnUpdate()->nullOnDelete();
            $table->dateTime('assigned_at')->nullable();

            $table->string('reminder')->nullable();
            $table->dateTime('reminder_date')->nullable();

            $table->longText('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_events');
    }
};
