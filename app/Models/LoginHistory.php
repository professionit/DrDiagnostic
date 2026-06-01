<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    protected $fillable = [
        'user_id', 'ip_address', 'user_agent', 'device',
        'location', 'is_successful', 'login_at', 'logout_at',
    ];

    protected $casts = [
        'is_successful' => 'boolean',
        'login_at' => 'datetime',
        'logout_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'subject_type', 'subject_id', 'event',
        'description', 'properties', 'ip_address', 'user_agent',
    ];

    protected $casts = ['properties' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->morphTo();
    }
}

class PatientVisit extends Model
{
    protected $fillable = [
        'patient_id', 'branch_id', 'doctor_id', 'referred_by_doctor_id',
        'visit_date', 'symptoms', 'diagnosis', 'notes', 'visit_fee',
    ];

    protected $casts = ['visit_date' => 'date', 'visit_fee' => 'decimal:2'];

    public function patient() { return $this->belongsTo(Patient::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function referredByDoctor() { return $this->belongsTo(Doctor::class, 'referred_by_doctor_id'); }
}

class PatientFollowUp extends Model
{
    protected $fillable = ['patient_id', 'doctor_id', 'visit_id', 'follow_up_date', 'notes', 'is_completed'];
    protected $casts = ['follow_up_date' => 'date', 'is_completed' => 'boolean'];
    public function patient() { return $this->belongsTo(Patient::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function visit() { return $this->belongsTo(PatientVisit::class); }
}