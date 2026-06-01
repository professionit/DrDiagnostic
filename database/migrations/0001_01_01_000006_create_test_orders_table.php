<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->unique();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('appointment_id')->nullable()->constrained()->nullOnDelete();
            $table->date('order_date');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->text('clinical_notes')->nullable();
            $table->text('diagnosis')->nullable();
            $table->boolean('is_urgent')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['order_date', 'status']);
        });

        Schema::create('test_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('diagnostic_services');
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->enum('sample_status', ['pending', 'collected', 'received', 'processing', 'completed'])->default('pending');
            $table->string('sample_id')->nullable();
            $table->timestamp('sample_collected_at')->nullable();
            $table->timestamp('sample_received_at')->nullable();
            $table->foreignId('sample_collected_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('sample_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('samples', function (Blueprint $table) {
            $table->id();
            $table->string('sample_id')->unique();
            $table->foreignId('test_order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('test_order_item_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('specimen_type_id')->nullable()->constrained()->nullOnDelete();
            $table->date('collection_date');
            $table->time('collection_time')->nullable();
            $table->string('collected_by')->nullable();
            $table->text('notes')->nullable();
            $table->string('barcode')->nullable();
            $table->enum('status', ['pending', 'collected', 'received', 'processing', 'completed', 'rejected'])->default('pending');
            $table->timestamp('received_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('samples');
        Schema::dropIfExists('test_order_items');
        Schema::dropIfExists('test_orders');
    }
};