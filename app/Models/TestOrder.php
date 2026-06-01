<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestOrder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_no', 'branch_id', 'patient_id', 'doctor_id',
        'appointment_id', 'order_date', 'status', 'clinical_notes',
        'diagnosis', 'is_urgent', 'created_by',
    ];

    protected $casts = ['order_date' => 'date', 'is_urgent' => 'boolean'];

    public function branch() { return $this->belongsTo(Branch::class); }
    public function patient() { return $this->belongsTo(Patient::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function appointment() { return $this->belongsTo(Appointment::class); }
    public function items() { return $this->hasMany(TestOrderItem::class); }
    public function samples() { return $this->hasMany(Sample::class); }
    public function reports() { return $this->hasMany(Report::class); }
    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); }
}

class TestOrderItem extends Model
{
    protected $fillable = ['test_order_id', 'service_id', 'price', 'discount', 'subtotal', 'sample_status', 'sample_id', 'sample_collected_at', 'sample_received_at', 'sample_collected_by', 'sample_notes'];
    protected $casts = ['price' => 'decimal:2', 'discount' => 'decimal:2', 'subtotal' => 'decimal:2'];
    
    public function testOrder() { return $this->belongsTo(TestOrder::class); }
    public function service() { return $this->belongsTo(DiagnosticService::class); }
    public function results() { return $this->hasMany(TestResult::class); }
    public function sample() { return $this->belongsTo(Sample::class); }
}

class Sample extends Model
{
    protected $fillable = ['sample_id', 'test_order_id', 'test_order_item_id', 'patient_id', 'specimen_type_id', 'collection_date', 'collection_time', 'collected_by', 'notes', 'barcode', 'status', 'received_at', 'rejection_reason', 'received_by'];
    protected $casts = ['collection_date' => 'date', 'collection_time' => 'datetime'];
    
    public function testOrder() { return $this->belongsTo(TestOrder::class); }
    public function patient() { return $this->belongsTo(Patient::class); }
    public function specimenType() { return $this->belongsTo(SpecimenType::class); }
}

class TestResult extends Model
{
    protected $fillable = ['test_order_item_id', 'parameter_id', 'parameter_name', 'result_value', 'unit', 'reference_range', 'remarks', 'is_abnormal', 'sort_order'];
    protected $casts = ['is_abnormal' => 'boolean'];
    
    public function testOrderItem() { return $this->belongsTo(TestOrderItem::class); }
    public function parameter() { return $this->belongsTo(TestParameter::class); }
}