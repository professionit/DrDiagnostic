<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\DiagnosticServiceController;
use App\Http\Controllers\TestOrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;

// Public Routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// Authenticated Routes
Route::middleware(['auth', 'branch.scope'])->group(function () {
    
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Patients
    Route::resource('patients', PatientController::class);
    Route::get('/patients/search', [PatientController::class, 'search'])->name('patients.search');
    Route::get('/patients/{patient}/history', [PatientController::class, 'history'])->name('patients.history');

    // Doctors
    Route::resource('doctors', DoctorController::class);
    Route::get('/doctors/{doctor}/schedule', [DoctorController::class, 'schedule'])->name('doctors.schedule');
    Route::post('/doctors/{doctor}/schedule', [DoctorController::class, 'storeSchedule'])->name('doctors.schedule.store');

    // Appointments
    Route::resource('appointments', AppointmentController::class);
    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.status');

    // Tokens & Queue
    Route::resource('tokens', TokenController::class)->only(['index', 'store', 'show']);
    Route::post('/tokens/{token}/call', [TokenController::class, 'call'])->name('tokens.call');
    Route::post('/tokens/{token}/complete', [TokenController::class, 'complete'])->name('tokens.complete');
    Route::post('/tokens/{token}/skip', [TokenController::class, 'skip'])->name('tokens.skip');
    Route::get('/queue', [TokenController::class, 'queueDisplay'])->name('queue.display');

    // Diagnostic Services
    Route::resource('services', DiagnosticServiceController::class);
    Route::resource('test-categories', TestCategoryController::class);

    // Test Orders
    Route::resource('test-orders', TestOrderController::class);
    Route::get('/test-orders/{testOrder}/print', [TestOrderController::class, 'print'])->name('test-orders.print');

    // Sample Management
    Route::get('/samples', [SampleController::class, 'index'])->name('samples.index');
    Route::post('/samples/{sample}/collect', [SampleController::class, 'collect'])->name('samples.collect');
    Route::post('/samples/{sample}/receive', [SampleController::class, 'receive'])->name('samples.receive');

    // Reports
    Route::resource('reports', ReportController::class);
    Route::patch('/reports/{report}/verify', [ReportController::class, 'verify'])->name('reports.verify');
    Route::patch('/reports/{report}/approve', [ReportController::class, 'approve'])->name('reports.approve');
    Route::patch('/reports/{report}/release', [ReportController::class, 'release'])->name('reports.release');
    Route::get('/reports/{report}/pdf', [ReportController::class, 'downloadPdf'])->name('reports.pdf');

    // Prescriptions
    Route::resource('prescriptions', PrescriptionController::class);
    Route::get('/prescriptions/{prescription}/print', [PrescriptionController::class, 'print'])->name('prescriptions.print');

    // Billing
    Route::resource('invoices', InvoiceController::class);
    Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
    Route::post('/invoices/{invoice}/payment', [PaymentController::class, 'store'])->name('invoices.payment');
    Route::post('/invoices/{invoice}/refund', [PaymentController::class, 'refund'])->name('invoices.refund');

    // Accounts
    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::get('/accounts/cashbook', [AccountController::class, 'cashbook'])->name('accounts.cashbook');
    Route::get('/accounts/profit-loss', [AccountController::class, 'profitLoss'])->name('accounts.profit-loss');
    Route::resource('expenses', ExpenseController::class);

    // Commission
    Route::get('/commission', [CommissionController::class, 'index'])->name('commission.index');
    Route::post('/commission/settle', [CommissionController::class, 'settle'])->name('commission.settle');
    Route::post('/commission/{settlement}/approve', [CommissionController::class, 'approve'])->name('commission.approve');

    // Inventory
    Route::resource('inventory', InventoryController::class);
    Route::get('/inventory/alerts', [InventoryController::class, 'alerts'])->name('inventory.alerts');
    Route::post('/inventory/{item}/adjust', [InventoryController::class, 'adjustStock'])->name('inventory.adjust');
    Route::resource('purchases', PurchaseController::class);

    // HR
    Route::resource('employees', EmployeeController::class);
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/mark', [AttendanceController::class, 'mark'])->name('attendance.mark');
    Route::resource('leaves', LeaveController::class);
    Route::resource('payroll', PayrollController::class);

    // Settings (Super Admin only)
    Route::middleware('role:Super Admin')->group(function () {
        Route::resource('branches', BranchController::class);
        Route::resource('users', UserController::class);
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
        Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
        Route::post('/backup/create', [BackupController::class, 'create'])->name('backup.create');
    });
});