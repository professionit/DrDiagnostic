<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice_no', 'branch_id', 'patient_id', 'appointment_id',
        'test_order_id', 'doctor_id', 'invoice_date', 'type',
        'subtotal', 'discount', 'discount_percentage', 'vat',
        'vat_percentage', 'total', 'paid_amount', 'due_amount',
        'payment_status', 'notes', 'created_by',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'subtotal' => 'decimal:2', 'discount' => 'decimal:2',
        'vat' => 'decimal:2', 'total' => 'decimal:2',
        'paid_amount' => 'decimal:2', 'due_amount' => 'decimal:2',
    ];

    public function branch() { return $this->belongsTo(Branch::class); }
    public function patient() { return $this->belongsTo(Patient::class); }
    public function appointment() { return $this->belongsTo(Appointment::class); }
    public function testOrder() { return $this->belongsTo(TestOrder::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function items() { return $this->hasMany(InvoiceItem::class); }
    public function payments() { return $this->hasMany(Payment::class); }
    public function refunds() { return $this->hasMany(Refund::class); }
    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); }

    public function scopePaid($q) { return $q->where('payment_status', 'paid'); }
    public function scopeUnpaid($q) { return $q->where('payment_status', 'unpaid'); }
    public function scopePartial($q) { return $q->where('payment_status', 'partial'); }
    public function scopeByDate($q, $date) { return $q->where('invoice_date', $date); }
}

class InvoiceItem extends Model
{
    protected $fillable = ['invoice_id', 'billable_type', 'billable_id', 'description', 'quantity', 'unit_price', 'discount', 'total'];
    protected $casts = ['unit_price' => 'decimal:2', 'total' => 'decimal:2'];
    public function invoice() { return $this->belongsTo(Invoice::class); }
    public function billable() { return $this->morphTo(); }
}

class Payment extends Model
{
    protected $fillable = ['payment_no', 'invoice_id', 'patient_id', 'branch_id', 'payment_date', 'amount', 'payment_method', 'reference_no', 'notes', 'received_by'];
    protected $casts = ['payment_date' => 'date', 'amount' => 'decimal:2'];
    public function invoice() { return $this->belongsTo(Invoice::class); }
    public function patient() { return $this->belongsTo(Patient::class); }
    public function receivedBy() { return $this->belongsTo(User::class, 'received_by'); }
}

class Refund extends Model
{
    protected $fillable = ['refund_no', 'invoice_id', 'payment_id', 'patient_id', 'refund_date', 'amount', 'reason', 'refund_method', 'processed_by'];
    protected $casts = ['refund_date' => 'date', 'amount' => 'decimal:2'];
    public function invoice() { return $this->belongsTo(Invoice::class); }
    public function payment() { return $this->belongsTo(Payment::class); }
}