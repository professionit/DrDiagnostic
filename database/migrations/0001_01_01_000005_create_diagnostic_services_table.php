<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('type', ['laboratory', 'imaging', 'cardiology', 'other'])->default('laboratory');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('diagnostic_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('test_categories')->nullOnDelete();
            $table->string('service_code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('cost_price', 10, 2)->default(0);
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->string('sample_type')->nullable();
            $table->text('preparation_instructions')->nullable();
            $table->text('reporting_notes')->nullable();
            $table->integer('turnaround_time_hours')->default(24);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_package')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('service_package_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('diagnostic_services')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('diagnostic_services')->cascadeOnDelete();
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('test_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('diagnostic_services')->cascadeOnDelete();
            $table->string('name');
            $table->string('unit')->nullable();
            $table->string('reference_range_male')->nullable();
            $table->string('reference_range_female')->nullable();
            $table->string('reference_range_child')->nullable();
            $table->string('reference_range_common')->nullable();
            $table->enum('input_type', ['text', 'number', 'select', 'boolean'])->default('text');
            $table->json('options')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('test_panels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('diagnostic_services')->cascadeOnDelete();
            $table->string('name');
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('specimen_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('specimen_types');
        Schema::dropIfExists('test_panels');
        Schema::dropIfExists('test_parameters');
        Schema::dropIfExists('service_package_items');
        Schema::dropIfExists('diagnostic_services');
        Schema::dropIfExists('test_categories');
    }
};