<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescription extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'prescription_no', 'branch_id', 'patient_id', 'doctor_id',
        'appointment_id', 'visit_id', 'prescription_date',
        'chief_complaint', 'history_of_present_illness', 'past_medical_history',
        'family_history', 'personal_history', 'allergies',
        'examination_findings', 'diagnosis', 'advice',
        'follow_up_notes', 'follow_up_date', 'notes', 'file_path', 'created_by',
    ];

    protected $casts = ['prescription_date' => 'date', 'follow_up_date' => 'date'];

    public function branch() { return $this->belongsTo(Branch::class); }
    public function patient() { return $this->belongsTo(Patient::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function appointment() { return $this->belongsTo(Appointment::class); }
    public function visit() { return $this->belongsTo(PatientVisit::class); }
    public function medicines() { return $this->hasMany(PrescriptionMedicine::class); }
    public function investigations() { return $this->hasMany(PrescriptionInvestigation::class); }
    public function diagnoses() { return $this->hasMany(PrescriptionDiagnosis::class); }
}

class PrescriptionMedicine extends Model
{
    protected $fillable = ['prescription_id', 'medicine_name', 'dosage', 'frequency', 'duration', 'instructions', 'route', 'is_ongoing', 'sort_order'];
    protected $casts = ['is_ongoing' => 'boolean'];
    public function prescription() { return $this->belongsTo(Prescription::class); }
}

class PrescriptionInvestigation extends Model
{
    protected $fillable = ['prescription_id', 'service_id', 'investigation_name', 'notes', 'is_completed'];
    protected $casts = ['is_completed' => 'boolean'];
    public function prescription() { return $this->belongsTo(Prescription::class); }
    public function service() { return $this->belongsTo(DiagnosticService::class); }
}

class PrescriptionDiagnosis extends Model
{
    protected $fillable = ['prescription_id', 'diagnosis_name', 'icd_code', 'notes'];
    public function prescription() { return $this->belongsTo(Prescription::class); }
}

class Token extends Model
{
    protected $fillable = ['branch_id', 'appointment_id', 'patient_id', 'doctor_id', 'token_no', 'token_date', 'status', 'calling_count', 'called_at', 'completed_at', 'created_by'];
    protected $casts = ['token_date' => 'date', 'called_at' => 'datetime', 'completed_at' => 'datetime'];
    
    public function branch() { return $this->belongsTo(Branch::class); }
    public function appointment() { return $this->belongsTo(Appointment::class); }
    public function patient() { return $this->belongsTo(Patient::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
}

class Queue extends Model
{
    protected $fillable = ['branch_id', 'doctor_id', 'queue_date', 'current_token', 'last_token', 'waiting_count', 'is_active'];
    protected $casts = ['queue_date' => 'date', 'is_active' => 'boolean'];
    
    public function branch() { return $this->belongsTo(Branch::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
}