<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Appointment extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'branch_id', 'patient_id', 'doctor_id', 'referred_by_doctor_id',
        'appointment_no', 'appointment_date', 'appointment_time',
        'status', 'type', 'notes', 'cancellation_reason',
        'consultation_fee', 'is_paid', 'created_by',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime',
        'is_paid' => 'boolean',
        'consultation_fee' => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['status', 'appointment_date'])->logOnlyDirty();
    }

    public function branch() { return $this->belongsTo(Branch::class); }
    public function patient() { return $this->belongsTo(Patient::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function referredByDoctor() { return $this->belongsTo(Doctor::class, 'referred_by_doctor_id'); }
    public function token() { return $this->hasOne(Token::class); }
    public function invoice() { return $this->hasOne(Invoice::class); }
    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); }

    public function scopeByDate($query, $date) { return $query->where('appointment_date', $date); }
    public function scopePending($query) { return $query->where('status', 'pending'); }
    public function scopeCompleted($query) { return $query->where('status', 'completed'); }
}