<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\PrescriptionController;
use App\Http\Controllers\Api\InvoiceController;

// Public API Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected API Routes
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user/profile', [AuthController::class, 'updateProfile']);

    // Patient Portal
    Route::get('/patients', [PatientController::class, 'index']);
    Route::get('/patients/{patient}', [PatientController::class, 'show']);
    Route::get('/patients/{patient}/appointments', [AppointmentController::class, 'patientAppointments']);
    Route::get('/patients/{patient}/reports', [ReportController::class, 'patientReports']);
    Route::get('/patients/{patient}/prescriptions', [PrescriptionController::class, 'patientPrescriptions']);
    Route::get('/patients/{patient}/invoices', [InvoiceController::class, 'patientInvoices']);

    // Appointments
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show']);
    Route::patch('/appointments/{appointment}', [AppointmentController::class, 'update']);
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy']);

    // Reports
    Route::get('/reports', [ReportController::class, 'index']);
    Route::get('/reports/{report}', [ReportController::class, 'show']);
    Route::get('/reports/{report}/download', [ReportController::class, 'download']);

    // Prescriptions
    Route::get('/prescriptions', [PrescriptionController::class, 'index']);
    Route::get('/prescriptions/{prescription}', [PrescriptionController::class, 'show']);

    // Invoices & Payments
    Route::get('/invoices', [InvoiceController::class, 'index']);
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show']);
    Route::post('/invoices/{invoice}/pay', [InvoiceController::class, 'pay']);

    // Doctors
    Route::get('/doctors', [AppointmentController::class, 'doctors']);
    Route::get('/doctors/{doctor}/slots', [AppointmentController::class, 'availableSlots']);

    // Dashboard Stats
    Route::get('/dashboard/stats', [PatientController::class, 'dashboardStats']);
});