<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('referred_by_doctor_id')->nullable()->constrained('doctors')->nullOnDelete();
            $table->string('appointment_no')->unique();
            $table->date('appointment_date');
            $table->time('appointment_time')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->enum('type', ['online', 'walk_in', 'follow_up'])->default('walk_in');
            $table->text('notes')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->decimal('consultation_fee', 10, 2)->default(0);
            $table->boolean('is_paid')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['appointment_date', 'doctor_id']);
            $table->index(['patient_id', 'appointment_date']);
        });

        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('appointment_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained()->nullOnDelete();
            $table->string('token_no');
            $table->date('token_date');
            $table->enum('status', ['waiting', 'called', 'completed', 'skipped'])->default('waiting');
            $table->integer('calling_count')->default(0);
            $table->timestamp('called_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['branch_id', 'token_date', 'token_no']);
            $table->index(['token_date', 'doctor_id', 'status']);
        });

        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained()->nullOnDelete();
            $table->date('queue_date');
            $table->integer('current_token')->default(0);
            $table->integer('last_token')->default(0);
            $table->integer('waiting_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['branch_id', 'doctor_id', 'queue_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('queues');
        Schema::dropIfExists('tokens');
        Schema::dropIfExists('appointments');
    }
};