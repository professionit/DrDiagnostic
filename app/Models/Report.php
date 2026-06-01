<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'report_no', 'branch_id', 'patient_id', 'doctor_id',
        'test_order_id', 'report_date', 'status', 'clinical_notes',
        'conclusion', 'notes', 'file_path', 'qr_code',
        'verified_at', 'verified_by', 'approved_at', 'approved_by',
        'released_at', 'released_by', 'created_by',
    ];

    protected $casts = ['report_date' => 'date', 'verified_at' => 'datetime', 'approved_at' => 'datetime', 'released_at' => 'datetime'];

    public function branch() { return $this->belongsTo(Branch::class); }
    public function patient() { return $this->belongsTo(Patient::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function testOrder() { return $this->belongsTo(TestOrder::class); }
    public function items() { return $this->hasMany(ReportItem::class); }
    public function media() { return $this->hasMany(ReportMedia::class); }
    public function verifiedBy() { return $this->belongsTo(User::class, 'verified_by'); }
    public function approvedBy() { return $this->belongsTo(User::class, 'approved_by'); }
    public function releasedBy() { return $this->belongsTo(User::class, 'released_by'); }

    public function scopeDraft($q) { return $q->where('status', 'draft'); }
    public function scopeApproved($q) { return $q->where('status', 'approved'); }
    public function scopeReleased($q) { return $q->where('status', 'released'); }
}

class ReportItem extends Model
{
    protected $fillable = ['report_id', 'service_id', 'service_name', 'result_text', 'comments', 'sort_order'];
    public function report() { return $this->belongsTo(Report::class); }
    public function service() { return $this->belongsTo(DiagnosticService::class); }
}

class ReportMedia extends Model
{
    protected $fillable = ['report_id', 'file_name', 'file_path', 'file_type', 'mime_type', 'file_size', 'is_doctor_signature'];
    protected $casts = ['is_doctor_signature' => 'boolean'];
    public function report() { return $this->belongsTo(Report::class); }
}