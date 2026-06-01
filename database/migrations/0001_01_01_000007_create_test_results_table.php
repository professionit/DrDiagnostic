<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_order_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parameter_id')->nullable()->constrained('test_parameters')->nullOnDelete();
            $table->string('parameter_name');
            $table->string('result_value')->nullable();
            $table->string('unit')->nullable();
            $table->string('reference_range')->nullable();
            $table->text('remarks')->nullable();
            $table->boolean('is_abnormal')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_no')->unique();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('test_order_id')->nullable()->constrained()->nullOnDelete();
            $table->date('report_date');
            $table->enum('status', ['draft', 'verified', 'approved', 'released'])->default('draft');
            $table->text('clinical_notes')->nullable();
            $table->text('conclusion')->nullable();
            $table->text('notes')->nullable();
            $table->string('file_path')->nullable();
            $table->string('qr_code')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('released_at')->nullable();
            $table->foreignId('released_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['report_date', 'status']);
            $table->index(['patient_id', 'report_date']);
        });

        Schema::create('report_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->nullable()->constrained('diagnostic_services')->nullOnDelete();
            $table->string('service_name');
            $table->text('result_text')->nullable();
            $table->text('comments')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('report_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->cascadeOnDelete();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->string('mime_type')->nullable();
            $table->integer('file_size')->nullable();
            $table->boolean('is_doctor_signature')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_media');
        Schema::dropIfExists('report_items');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('test_results');
    }
};