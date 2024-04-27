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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('notes')->nullable();
            $table->foreignId('branch_id')->nullable()->constrained('branches', 'id')->cascadeOnUpdate()->nullOnDelete();

            $table->foreignId('event_id')->nullable()->default(1)->constrained('events', 'id')->cascadeOnUpdate()->nullOnDelete();
            $table->string('event')->default('fresh');
            $table->dateTime('event_created_at')->nullable();

            $table->string('reminder')->nullable();
            $table->dateTime('reminder_date')->nullable();

            $table->foreignId('assigned_by')->nullable()->constrained('users', 'id')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users', 'id')->cascadeOnUpdate()->nullOnDelete();
            $table->dateTime('assigned_at')->nullable();

            $table->boolean('show_old_hisory')->default(0);

            $table->softDeletes();

            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->cascadeOnUpdate()->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
