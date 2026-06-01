<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Doctor extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'user_id',
        'specialization_id',
        'doctor_id',
        'name',
        'phone',
        'email',
        'bmdc_reg_no',
        'qualification',
        'photo',
        'biography',
        'experience_years',
        'consultation_fee',
        'follow_up_fee',
        'commission_percentage',
        'has_commission',
        'commission_type',
        'fixed_commission',
        'is_active',
        'is_referral_doctor',
    ];

    protected $casts = [
        'has_commission' => 'boolean',
        'is_active' => 'boolean',
        'is_referral_doctor' => 'boolean',
        'consultation_fee' => 'decimal:2',
        'follow_up_fee' => 'decimal:2',
        'commission_percentage' => 'decimal:2',
        'fixed_commission' => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'phone', 'is_active', 'consultation_fee'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function leaves()
    {
        return $this->hasMany(DoctorLeave::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function tokens()
    {
        return $this->hasMany(Token::class);
    }

    public function referredPatients()
    {
        return $this->hasMany(Patient::class, 'referred_by_doctor_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeReferral($query)
    {
        return $query->where('is_referral_doctor', true);
    }

    public function commissionSettlements()
    {
        return $this->hasMany(CommissionSettlement::class);
    }
}