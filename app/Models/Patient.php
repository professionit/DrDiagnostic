<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Patient extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'branch_id',
        'patient_id',
        'name',
        'phone',
        'email',
        'date_of_birth',
        'gender',
        'blood_group',
        'address',
        'photo',
        'medical_history',
        'allergies',
        'current_medications',
        'emergency_contact_name',
        'emergency_contact_phone',
        'referral_source',
        'referred_by_doctor_id',
        'is_active',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'phone', 'patient_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function referredByDoctor()
    {
        return $this->belongsTo(Doctor::class, 'referred_by_doctor_id');
    }

    public function visits()
    {
        return $this->hasMany(PatientVisit::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function tokens()
    {
        return $this->hasMany(Token::class);
    }

    public function testOrders()
    {
        return $this->hasMany(TestOrder::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function followUps()
    {
        return $this->hasMany(PatientFollowUp::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('phone', 'like', "%{$term}%")
              ->orWhere('patient_id', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%");
        });
    }
}