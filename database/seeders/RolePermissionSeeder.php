<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Branch Management
            'branches.create', 'branches.view', 'branches.edit', 'branches.delete',
            
            // User Management
            'users.create', 'users.view', 'users.edit', 'users.delete',
            
            // Patient Management
            'patients.create', 'patients.view', 'patients.edit', 'patients.delete',
            'patients.search',
            
            // Doctor Management
            'doctors.create', 'doctors.view', 'doctors.edit', 'doctors.delete',
            
            // Appointment Management
            'appointments.create', 'appointments.view', 'appointments.edit', 'appointments.delete',
            'appointments.confirm', 'appointments.cancel',
            
            // Token Management
            'tokens.create', 'tokens.view', 'tokens.call', 'tokens.skip',
            
            // Diagnostic Services
            'services.create', 'services.view', 'services.edit', 'services.delete',
            
            // Test Orders
            'test-orders.create', 'test-orders.view', 'test-orders.edit', 'test-orders.delete',
            
            // Sample Management
            'samples.collect', 'samples.receive', 'samples.process', 'samples.view',
            
            // Reports
            'reports.create', 'reports.view', 'reports.edit', 'reports.delete',
            'reports.verify', 'reports.approve', 'reports.release',
            'reports.print',
            
            // Prescriptions
            'prescriptions.create', 'prescriptions.view', 'prescriptions.edit', 'prescriptions.delete',
            'prescriptions.print',
            
            // Billing
            'invoices.create', 'invoices.view', 'invoices.edit', 'invoices.delete',
            'invoices.payment', 'invoices.refund', 'invoices.print',
            
            // Accounts
            'accounts.view', 'accounts.transactions',
            'expenses.create', 'expenses.view', 'expenses.edit', 'expenses.delete',
            'expenses.approve',
            
            // Commission
            'commission.view', 'commission.settle', 'commission.approve',
            
            // Inventory
            'inventory.create', 'inventory.view', 'inventory.edit', 'inventory.delete',
            'inventory.purchase', 'inventory.adjust',
            
            // HR
            'employees.create', 'employees.view', 'employees.edit', 'employees.delete',
            'attendance.manage', 'leave.manage', 'payroll.manage',
            
            // Settings
            'settings.view', 'settings.edit',
            
            // Reports & Analytics
            'reports.dashboard', 'reports.financial', 'reports.statistics',
            
            // SMS
            'sms.send', 'sms.templates',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions
        $superAdmin = Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);
        $superAdmin->givePermissionTo(Permission::all());

        $branchAdmin = Role::create(['name' => 'Branch Admin', 'guard_name' => 'web']);
        $branchAdmin->givePermissionTo([
            'patients.*', 'doctors.*', 'appointments.*', 'tokens.*',
            'services.view', 'test-orders.*', 'samples.*',
            'reports.*', 'prescriptions.*', 'invoices.*',
            'accounts.view', 'accounts.transactions',
            'expenses.*', 'commission.view',
            'inventory.*', 'employees.view',
            'reports.dashboard', 'reports.financial',
            'sms.send',
        ]);

        $receptionist = Role::create(['name' => 'Receptionist', 'guard_name' => 'web']);
        $receptionist->givePermissionTo([
            'patients.create', 'patients.view', 'patients.edit', 'patients.search',
            'appointments.create', 'appointments.view', 'appointments.edit',
            'tokens.create', 'tokens.view', 'tokens.call', 'tokens.skip',
            'invoices.create', 'invoices.view', 'invoices.payment', 'invoices.print',
        ]);

        $doctor = Role::create(['name' => 'Doctor', 'guard_name' => 'web']);
        $doctor->givePermissionTo([
            'patients.view', 'patients.search',
            'appointments.view', 'appointments.edit',
            'tokens.view',
            'test-orders.create', 'test-orders.view',
            'reports.view',
            'prescriptions.create', 'prescriptions.view', 'prescriptions.edit', 'prescriptions.print',
        ]);

        $pathologist = Role::create(['name' => 'Pathologist', 'guard_name' => 'web']);
        $pathologist->givePermissionTo([
            'patients.view', 'patients.search',
            'test-orders.view', 'test-orders.edit',
            'samples.collect', 'samples.receive', 'samples.process', 'samples.view',
            'reports.create', 'reports.view', 'reports.edit',
            'reports.verify', 'reports.approve', 'reports.release',
        ]);

        $accountant = Role::create(['name' => 'Accountant', 'guard_name' => 'web']);
        $accountant->givePermissionTo([
            'invoices.view', 'invoices.payment', 'invoices.refund', 'invoices.print',
            'accounts.view', 'accounts.transactions',
            'expenses.create', 'expenses.view', 'expenses.edit',
            'commission.view',
            'reports.financial',
        ]);
    }
}