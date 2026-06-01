<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) - {{ config('app.name') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="sidebar bg-dark text-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 px-3 border-bottom border-secondary">
                <i class="bi bi-hospital fs-3"></i>
                <h6 class="mt-2 mb-0">{{ config('app.name') }}</h6>
            </div>
            <div class="list-group list-group-flush">
                @role('Super Admin')
                <a href="{{ route('branches.index') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('branches.*') ? 'active' : '' }}">
                    <i class="bi bi-building me-2"></i> Branches
                </a>
                <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="bi bi-people me-2"></i> Users
                </a>
                @endrole

                <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
                <a href="{{ route('patients.index') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('patients.*') ? 'active' : '' }}">
                    <i class="bi bi-person-heart me-2"></i> Patients
                </a>
                <a href="{{ route('doctors.index') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('doctors.*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge me-2"></i> Doctors
                </a>
                <a href="{{ route('appointments.index') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('appointments.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check me-2"></i> Appointments
                </a>
                <a href="{{ route('queue.display') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('queue.*') ? 'active' : '' }}">
                    <i class="bi bi-view-stacked me-2"></i> Queue
                </a>

                <div class="list-group-item bg-dark text-secondary fw-bold small px-3 py-2">
                    <i class="bi bi-clipboard2-pulse me-2"></i> Diagnostics
                </div>
                <a href="{{ route('services.index') }}" class="list-group-item list-group-item-action bg-dark text-white ps-5 {{ request()->routeIs('services.*') ? 'active' : '' }}">
                    Services
                </a>
                <a href="{{ route('test-orders.index') }}" class="list-group-item list-group-item-action bg-dark text-white ps-5 {{ request()->routeIs('test-orders.*') ? 'active' : '' }}">
                    Test Orders
                </a>
                <a href="{{ route('samples.index') }}" class="list-group-item list-group-item-action bg-dark text-white ps-5 {{ request()->routeIs('samples.*') ? 'active' : '' }}">
                    Samples
                </a>
                <a href="{{ route('reports.index') }}" class="list-group-item list-group-item-action bg-dark text-white ps-5 {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    Reports
                </a>
                <a href="{{ route('prescriptions.index') }}" class="list-group-item list-group-item-action bg-dark text-white ps-5 {{ request()->routeIs('prescriptions.*') ? 'active' : '' }}">
                    Prescriptions
                </a>

                <div class="list-group-item bg-dark text-secondary fw-bold small px-3 py-2">
                    <i class="bi bi-cash-coin me-2"></i> Finance
                </div>
                <a href="{{ route('invoices.index') }}" class="list-group-item list-group-item-action bg-dark text-white ps-5 {{ request()->routeIs('invoices.*') ? 'active' : '' }}">
                    Billing
                </a>
                <a href="{{ route('accounts.index') }}" class="list-group-item list-group-item-action bg-dark text-white ps-5 {{ request()->routeIs('accounts.*') ? 'active' : '' }}">
                    Accounts
                </a>
                <a href="{{ route('expenses.index') }}" class="list-group-item list-group-item-action bg-dark text-white ps-5 {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                    Expenses
                </a>
                <a href="{{ route('commission.index') }}" class="list-group-item list-group-item-action bg-dark text-white ps-5 {{ request()->routeIs('commission.*') ? 'active' : '' }}">
                    Commission
                </a>

                <div class="list-group-item bg-dark text-secondary fw-bold small px-3 py-2">
                    <i class="bi bi-box-seam me-2"></i> Inventory
                </div>
                <a href="{{ route('inventory.index') }}" class="list-group-item list-group-item-action bg-dark text-white ps-5 {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
                    Items
                </a>
                <a href="{{ route('purchases.index') }}" class="list-group-item list-group-item-action bg-dark text-white ps-5 {{ request()->routeIs('purchases.*') ? 'active' : '' }}">
                    Purchases
                </a>

                <div class="list-group-item bg-dark text-secondary fw-bold small px-3 py-2">
                    <i class="bi bi-people me-2"></i> HR
                </div>
                <a href="{{ route('employees.index') }}" class="list-group-item list-group-item-action bg-dark text-white ps-5 {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                    Employees
                </a>
                <a href="{{ route('attendance.index') }}" class="list-group-item list-group-item-action bg-dark text-white ps-5 {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                    Attendance
                </a>

                @role('Super Admin')
                <div class="list-group-item bg-dark text-secondary fw-bold small px-3 py-2">
                    <i class="bi bi-gear me-2"></i> Settings
                </div>
                <a href="{{ route('settings.index') }}" class="list-group-item list-group-item-action bg-dark text-white ps-5 {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    System Settings
                </a>
                <a href="{{ route('backup.index') }}" class="list-group-item list-group-item-action bg-dark text-white ps-5 {{ request()->routeIs('backup.*') ? 'active' : '' }}">
                    Backup
                </a>
                @endrole
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper" class="w-100">
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">
                <button class="btn btn-dark" id="menu-toggle">
                    <i class="bi bi-list"></i>
                </button>
                <div class="ms-auto d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-2"></i>{{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container-fluid px-4 py-3">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        // Sidebar Toggle
        document.getElementById('menu-toggle')?.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('wrapper').classList.toggle('toggled');
        });

        // Initialize Select2
        $(document).ready(function() {
            $('.select2').select2({ theme: 'bootstrap-5' });
            $('.datatable').DataTable({
                responsive: true,
                language: { search: "_INPUT_", searchPlaceholder: "Search..." }
            });
        });

        // Auto-hide alerts
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
    @stack('scripts')
</body>
</html>