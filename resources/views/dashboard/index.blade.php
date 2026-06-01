@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">
        <i class="bi bi-speedometer2 me-2"></i>Dashboard
    </h4>
    <span class="text-muted">{{ now()->format('l, d F Y') }}</span>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card border-start border-primary border-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 fs-7">Today's Patients</p>
                        <h3 class="mb-0 text-primary">{{ $stats['today_patients'] }}</h3>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10">
                        <i class="bi bi-people text-primary"></i>
                    </div>
                </div>
                <small class="text-muted">Total: {{ $stats['total_patients'] }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-start border-success border-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 fs-7">Today's Revenue</p>
                        <h3 class="mb-0 text-success">৳{{ number_format($stats['today_revenue'], 2) }}</h3>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10">
                        <i class="bi bi-cash-coin text-success"></i>
                    </div>
                </div>
                <small class="text-muted">{{ $stats['today_appointments'] }} Appointments</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-start border-warning border-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 fs-7">Pending Reports</p>
                        <h3 class="mb-0 text-warning">{{ $stats['pending_reports'] }}</h3>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10">
                        <i class="bi bi-file-earmark-text text-warning"></i>
                    </div>
                </div>
                <small class="text-muted">{{ $stats['today_orders'] }} Today's Orders</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-start border-danger border-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 fs-7">Pending Payments</p>
                        <h3 class="mb-0 text-danger">{{ $stats['pending_payments'] }}</h3>
                    </div>
                    <div class="stat-icon bg-danger bg-opacity-10">
                        <i class="bi bi-credit-card-2-front text-danger"></i>
                    </div>
                </div>
                <small class="text-muted">{{ $stats['total_doctors'] }} Active Doctors</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Revenue Chart -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Revenue Overview (Last 7 Days)</span>
                <span class="badge bg-primary">Today: ৳{{ number_format($stats['today_revenue'], 2) }}</span>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointment Status -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Today's Appointments</div>
            <div class="card-body">
                <div class="chart-container" style="height: 250px;">
                    <canvas id="appointmentChart"></canvas>
                </div>
                <div class="mt-3">
                    @foreach(['pending', 'confirmed', 'completed', 'cancelled'] as $status)
                        <div class="d-flex justify-content-between mb-1">
                            <span>
                                <span class="badge bg-{{ 
                                    $status == 'pending' ? 'warning' : 
                                    ($status == 'confirmed' ? 'info' : 
                                    ($status == 'completed' ? 'success' : 'danger'))
                                }}" style="width: 10px; height: 10px; border-radius: 50%; display: inline-block;"></span>
                                {{ ucfirst($status) }}
                            </span>
                            <span class="fw-bold">{{ $appointmentStats[$status] ?? 0 }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Recent Appointments -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span>Recent Appointments</span>
                <a href="{{ route('appointments.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAppointments as $appointment)
                            <tr>
                                <td>
                                    <strong>{{ $appointment->patient?->name }}</strong>
                                    <br><small class="text-muted">{{ $appointment->patient?->phone }}</small>
                                </td>
                                <td>{{ $appointment->doctor?->name ?? 'N/A' }}</td>
                                <td>{{ $appointment->appointment_time ? $appointment->appointment_time->format('h:i A') : '--' }}</td>
                                <td>@statusBadge($appointment->status)</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">No appointments today</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Patients -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span>Recent Patients</span>
                <a href="{{ route('patients.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($recentPatients as $patient)
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                <i class="bi bi-person text-primary"></i>
                            </div>
                            <div>
                                <strong>{{ $patient->name }}</strong>
                                <br><small class="text-muted">{{ $patient->patient_id }}</small>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-muted text-center">No recent patients</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Top Tests -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <span>Top Tests (This Month)</span>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($topTests as $test)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ $test->name }}</span>
                        <span class="badge bg-primary rounded-pill">{{ $test->total }}</span>
                    </li>
                    @empty
                    <li class="list-group-item text-muted text-center">No test data</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueData = @json($revenueChart);

new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: Object.keys(revenueData).map(d => {
            const date = new Date(d);
            return date.toLocaleDateString('en-US', { weekday: 'short', day: 'numeric' });
        }),
        datasets: [{
            label: 'Revenue',
            data: Object.values(revenueData),
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13, 110, 253, 0.1)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { callback: value => '৳' + value.toLocaleString() }
            }
        }
    }
});

// Appointment Chart
const appointCtx = document.getElementById('appointmentChart').getContext('2d');
const appointData = @json($appointmentStats);

new Chart(appointCtx, {
    type: 'doughnut',
    data: {
        labels: Object.keys(appointData).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
        datasets: [{
            data: Object.values(appointData),
            backgroundColor: ['#ffc107', '#0dcaf0', '#198754', '#dc3545'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } }
    }
});
</script>
@endpush