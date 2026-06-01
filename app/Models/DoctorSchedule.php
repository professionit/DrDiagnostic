<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    protected $fillable = ['doctor_id', 'branch_id', 'day_of_week', 'start_time', 'end_time', 'slot_duration', 'max_patients', 'is_active'];
    protected $casts = ['start_time' => 'datetime', 'end_time' => 'datetime', 'is_active' => 'boolean'];
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function branch() { return $this->belongsTo(Branch::class); }
}

class DoctorLeave extends Model
{
    protected $fillable = ['doctor_id', 'start_date', 'end_date', 'reason', 'is_approved', 'approved_by'];
    protected $casts = ['start_date' => 'date', 'end_date' => 'date', 'is_approved' => 'boolean'];
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function approvedBy() { return $this->belongsTo(User::class, 'approved_by'); }
}

class Specialization extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
    public function doctors() { return $this->hasMany(Doctor::class); }
}

class SpecimenType extends Model
{
    protected $fillable = ['name', 'description', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
}

class CommissionSettlement extends Model
{
    protected $fillable = ['doctor_id', 'branch_id', 'settlement_no', 'settlement_date', 'period_from', 'period_to', 'total_consultation_fee', 'total_test_fee', 'commission_amount', 'paid_amount', 'due_amount', 'status', 'notes', 'approved_by', 'paid_at'];
    protected $casts = ['settlement_date' => 'date', 'period_from' => 'date', 'period_to' => 'date', 'paid_at' => 'datetime'];
    public function doctor() { return $this->belongsTo(Doctor::class); }
}

class InventoryItem extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $fillable = ['item_code', 'name', 'description', 'supplier_id', 'category', 'unit', 'unit_price', 'purchase_price', 'current_stock', 'minimum_stock', 'maximum_stock', 'expiry_date', 'location', 'storage_condition', 'is_active'];
    protected $casts = ['expiry_date' => 'date', 'is_active' => 'boolean'];
    public function supplier() { return $this->belongsTo(Supplier::class); }
}

class Supplier extends Model
{
    protected $fillable = ['name', 'contact_person', 'phone', 'email', 'address', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
}

class StockPurchase extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $fillable = ['purchase_no', 'supplier_id', 'purchase_date', 'total_amount', 'paid_amount', 'due_amount', 'payment_status', 'notes', 'created_by'];
    protected $casts = ['purchase_date' => 'date'];
    public function supplier() { return $this->belongsTo(Supplier::class); }
    public function items() { return $this->hasMany(StockPurchaseItem::class); }
}

class StockPurchaseItem extends Model
{
    protected $fillable = ['stock_purchase_id', 'inventory_item_id', 'quantity', 'unit_price', 'total_price', 'expiry_date'];
    protected $casts = ['expiry_date' => 'date'];
    public function purchase() { return $this->belongsTo(StockPurchase::class); }
    public function item() { return $this->belongsTo(InventoryItem::class); }
}

class Employee extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $fillable = ['user_id', 'branch_id', 'employee_id', 'name', 'phone', 'email', 'date_of_birth', 'gender', 'address', 'photo', 'designation', 'department', 'joining_date', 'salary', 'employment_type', 'is_active'];
    protected $casts = ['date_of_birth' => 'date', 'joining_date' => 'date', 'is_active' => 'boolean'];
    public function user() { return $this->belongsTo(User::class); }
    public function branch() { return $this->belongsTo(Branch::class); }
}

class ChartOfAccount extends Model
{
    protected $fillable = ['branch_id', 'code', 'name', 'type', 'description', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
}

class Transaction extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $fillable = ['transaction_no', 'branch_id', 'account_id', 'invoice_id', 'transactionable_type', 'transactionable_id', 'transaction_date', 'type', 'amount', 'description', 'reference', 'created_by'];
    protected $casts = ['transaction_date' => 'date', 'amount' => 'decimal:2'];
    public function account() { return $this->belongsTo(ChartOfAccount::class); }
    public function transactionable() { return $this->morphTo(); }
}

class Expense extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $fillable = ['expense_no', 'branch_id', 'account_id', 'created_by', 'expense_date', 'amount', 'payee', 'description', 'reference', 'receipt', 'is_approved', 'approved_by', 'approved_at'];
    protected $casts = ['expense_date' => 'date', 'approved_at' => 'datetime', 'is_approved' => 'boolean'];
    public function account() { return $this->belongsTo(ChartOfAccount::class); }
}