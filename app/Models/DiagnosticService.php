<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiagnosticService extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id', 'service_code', 'name', 'description',
        'price', 'cost_price', 'discount_percentage', 'sample_type',
        'preparation_instructions', 'reporting_notes',
        'turnaround_time_hours', 'is_active', 'is_package',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'is_active' => 'boolean',
        'is_package' => 'boolean',
    ];

    public function category() { return $this->belongsTo(TestCategory::class, 'category_id'); }
    public function parameters() { return $this->hasMany(TestParameter::class); }
    public function packageItems() { return $this->hasMany(ServicePackageItem::class, 'package_id'); }
    public function scopeActive($q) { return $q->where('is_active', true); }
    public function scopeLaboratory($q) { return $q->whereHas('category', fn($q) => $q->where('type', 'laboratory')); }
    public function scopeImaging($q) { return $q->whereHas('category', fn($q) => $q->where('type', 'imaging')); }
}

class TestCategory extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'type', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
    public function services() { return $this->hasMany(DiagnosticService::class, 'category_id'); }
}

class TestParameter extends Model
{
    protected $fillable = ['service_id', 'name', 'unit', 'reference_range_male', 'reference_range_female', 'reference_range_child', 'reference_range_common', 'input_type', 'options', 'sort_order', 'is_active'];
    protected $casts = ['options' => 'array', 'is_active' => 'boolean'];
    public function service() { return $this->belongsTo(DiagnosticService::class); }
}

class ServicePackageItem extends Model
{
    protected $fillable = ['package_id', 'service_id', 'discount_percentage'];
    public function package() { return $this->belongsTo(DiagnosticService::class, 'package_id'); }
    public function service() { return $this->belongsTo(DiagnosticService::class); }
}