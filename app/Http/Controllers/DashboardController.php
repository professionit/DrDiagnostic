<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Report;
use App\Models\TestOrder;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $branchId = auth()->user()->branch_id;

        $stats = [
            'today_patients' => Patient::when($branchId, fn($q) => $q->where('branch_id', $branchId))
                ->whereDate('created_at', $today)->count(),

            'today_appointments' => Appointment::when($branchId, fn($q) => $q->where('branch_id', $branchId))
                ->whereDate('appointment_date', $today)->count(),

            'today_revenue' => Invoice::when($branchId, fn($q) => $q->where('branch_id', $branchId))
                ->whereDate('invoice_date', $today)->sum('total'),

            'pending_reports' => Report::when($branchId, fn($q) => $q->where('branch_id', $branchId))
                ->whereIn('status', ['draft', 'verified'])->count(),

            'pending_payments' => Invoice::when($branchId, fn($q) => $q->where('branch_id', $branchId))
                ->where('payment_status', 'unpaid')->where('due_amount', '>', 0)->count(),

            'total_doctors' => Doctor::where('is_active', true)->count(),
            'total_patients' => Patient::when($branchId, fn($q) => $q->where('branch_id', $branchId))->count(),
            'today_orders' => TestOrder::when($branchId, fn($q) => $q->where('branch_id', $branchId))
                ->whereDate('order_date', $today)->count(),
        ];

        // Revenue Chart Data (Last 7 Days)
        $revenueChart = Invoice::when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->whereDate('invoice_date', '>=', $today->subDays(6))
            ->select(DB::raw('DATE(invoice_date) as date'), DB::raw('SUM(total) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        // Appointment Status Distribution
        $appointmentStats = Appointment::when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->whereDate('appointment_date', $today)
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Recent Appointments
        $recentAppointments = Appointment::with(['patient:id,name,phone', 'doctor:id,name'])
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->whereDate('appointment_date', $today)
            ->orderBy('appointment_time')
            ->limit(10)
            ->get();

        // Recent Patients
        $recentPatients = Patient::when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->latest()
            ->limit(10)
            ->get();

        // Top Performing Tests
        $topTests = TestOrder::join('test_order_items', 'test_orders.id', '=', 'test_order_items.test_order_id')
            ->join('diagnostic_services', 'test_order_items.service_id', '=', 'diagnostic_services.id')
            ->select('diagnostic_services.name', DB::raw('COUNT(*) as total'))
            ->when($branchId, fn($q) => $q->where('test_orders.branch_id', $branchId))
            ->whereMonth('test_orders.order_date', now()->month)
            ->groupBy('diagnostic_services.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'stats', 'revenueChart', 'appointmentStats',
            'recentAppointments', 'recentPatients', 'topTests'
        ));
    }
}