# 🏥 Modern Diagnostic Centre & Doctor Chamber Management System

A comprehensive, production-ready web-based healthcare management solution built with **Laravel 12**, designed for diagnostic centres and doctor chambers in Bangladesh.

## ✨ Features

### 👥 Patient Management
- Auto-generated Patient ID (P-000001)
- Complete patient profiles with photo, medical history, allergies
- Multiple contact & emergency contact information
- Visit history tracking & follow-up management
- Advanced search by ID, name, phone, email

### 👨‍⚕️ Doctor Management
- Doctor profiles with BMDC registration
- Specialization management
- Dynamic chamber scheduling
- Consultation & follow-up fee configuration
- Referral & commission tracking

### 📅 Appointment & Token System
- Online & walk-in appointment booking
- Auto token generation with queue management
- Real-time calling system
- Appointment status workflow (Pending → Confirmed → Completed/Cancelled)
- Digital queue display

### 🔬 Diagnostic Services
- Comprehensive test categories (Hematology, Biochemistry, Microbiology, etc.)
- Test parameter management with reference ranges
- Package/panel creation
- Sample collection workflow (Collected → Received → Processing → Completed)
- Barcode/QR code support

### 📊 Laboratory Information System (LIS)
- End-to-end sample tracking
- Test result entry & validation
- Multi-level report verification (Draft → Verified → Approved → Released)
- Dynamic PDF report generation with QR verification
- Doctor digital signature support

### 💉 Prescription System
- Digital prescription in A4 format
- Medicine management with dosage, frequency, duration
- Diagnosis entry with ICD-10 code support
- Investigation recommendations
- Follow-up scheduling

### 💰 Billing & Accounts
- Consultation, test, and package billing
- Multi-payment support (Cash, Card, bKash, Nagad, Rocket)
- Discount & VAT management
- Invoice printing & refund processing
- Daily cashbook, profit & loss reports
- Doctor commission calculation & settlement

### 📦 Inventory Management
- Medical supplies & reagent tracking
- Purchase order management
- Stock level alerts (low stock & expiry)
- Supplier management
- Stock adjustments

### 👔 HR & Payroll
- Employee management with departments
- Attendance tracking
- Leave management
- Payroll processing

### 📱 Patient Portal
- Online appointment booking
- Report & prescription download
- Billing history
- Mobile app API ready

### 🏢 Multi-Branch Support
- Unlimited branch management
- Branch-wise reporting & analytics
- Branch-specific doctor scheduling

## 🛠️ Technology Stack

| Technology | Version |
|------------|---------|
| **Laravel** | 12.x |
| **PHP** | 8.3+ |
| **MySQL** | 8.0+ |
| **Bootstrap** | 5.3 |
| **Livewire** | 3.x |
| **jQuery/DataTables** | Latest |
| **Chart.js** | Latest |
| **DomPDF** | Latest |

### Key Packages
- **spatie/laravel-permission** - RBAC with 6 user roles
- **spatie/laravel-activitylog** - Comprehensive audit trail
- **barryvdh/laravel-dompdf** - PDF report generation
- **milon/barcode** - Barcode generation
- **intervention/image** - Image processing
- **maatwebsite/laravel-excel** - Excel export/import

## 👥 User Roles

| Role | Permissions |
|------|------------|
| **Super Admin** | Full system control, branches, users, settings, backup |
| **Branch Admin** | Branch operations, appointments, billing, reports |
| **Receptionist** | Patient registration, appointments, tokens, billing collection |
| **Doctor** | Appointments, prescriptions, patient history, investigations |
| **Pathologist** | Test results, verification, report approval |
| **Accountant** | Income/expense management, financial reports |

## 🗄️ Database Schema (50+ Tables)

### Core Tables
- `branches`, `users`, `patients`, `doctors`, `specializations`
- `appointments`, `tokens`, `queues`

### Diagnostics
- `test_categories`, `diagnostic_services`, `test_parameters`
- `test_orders`, `test_order_items`, `test_results`
- `samples`, `reports`, `report_items`, `report_media`

### Clinical
- `prescriptions`, `prescription_medicines`, `prescription_diagnoses`
- `patient_visits`, `patient_follow_ups`

### Financial
- `invoices`, `invoice_items`, `payments`, `refunds`
- `chart_of_accounts`, `transactions`, `expenses`
- `commission_settlements`, `cashbooks`

### Inventory
- `inventory_items`, `suppliers`, `stock_purchases`
- `stock_adjustments`, `stock_alerts`

### HR
- `employees`, `employee_attendances`, `employee_leaves`, `payrolls`

### Security & Audit
- `activity_logs`, `login_histories`
- `model_has_roles`, `model_has_permissions`, `role_has_permissions`

## 🚀 Quick Installation

```bash
# Clone the repository
git clone <repository-url> diagnostic-centre
cd diagnostic-centre

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install && npm run build

# Environment setup
cp .env.example .env
php artisan key:generate
# Edit .env with your database credentials

# Database setup
php artisan migrate --seed

# Storage
php artisan storage:link

# Start development server
php artisan serve
```

### Default Login
```
Email:    admin@diagnostic.com
Password: password
Role:     Super Admin
```

## 🔒 Security Features

- **RBAC** (Spatie Permission) with 6 roles
- **Rate Limiting** on login attempts
- **CSRF Protection** on all forms
- **XSS Protection** (Blade escaping)
- **SQL Injection Prevention** (Eloquent ORM)
- **Input Validation** (Form Requests)
- **Activity Logging** for all critical actions
- **Login History** tracking
- **Two-Factor Authentication** ready

## 📈 Performance Optimizations

- Eager loading to prevent N+1 queries
- Database indexing on frequently queried columns
- Queue worker for SMS, PDF generation
- Scheduler for automated tasks
- Caching support (Redis/File)
- Optimized for LAMP stack deployment

## 🐳 Deployment (Endor LAMP Runtime)

The application is fully compatible with **Endor LAMP Runtime**. See [DEPLOYMENT.md](DEPLOYMENT.md) for detailed instructions.

### Nginx Configuration
```nginx
server {
    listen 80;
    server_name diagnostic.example.com;
    root /var/www/diagnostic/public;
    # ... (see DEPLOYMENT.md for full config)
}
```

## 📁 Project Structure

```
├── app/
│   ├── Enums/           # PHP 8.3 Enums
│   ├── Http/
│   │   ├── Controllers/ # 40+ Controllers
│   │   ├── Middleware/   # BranchScope, etc.
│   │   └── Requests/    # Form validation
│   ├── Models/          # 50+ Eloquent Models
│   ├── Repositories/    # Repository Pattern
│   └── Services/        # Service Layer
├── database/
│   ├── migrations/      # 13 migration files
│   └── seeders/         # RBAC, test data
├── resources/
│   └── views/           # Blade templates
└── routes/
    ├── web.php          # 70+ web routes
    └── api.php          # RESTful API endpoints
```

## 🔄 API Endpoints (Mobile App Ready)

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/login` | User login |
| POST | `/api/register` | Patient registration |
| GET | `/api/v1/patients` | List patients |
| GET | `/api/v1/appointments` | List appointments |
| POST | `/api/v1/appointments` | Create appointment |
| GET | `/api/v1/reports` | View reports |
| GET | `/api/v1/reports/{id}/download` | Download report PDF |
| GET | `/api/v1/prescriptions` | View prescriptions |
| GET | `/api/v1/invoices` | View invoices |
| POST | `/api/v1/invoices/{id}/pay` | Make payment |

## 📊 Dashboard Widgets

- Today's Patient Count & Revenue
- Pending Reports & Payments
- Revenue Chart (7-day trend)
- Appointment Status Distribution
- Recent Appointments & Patients
- Top Performing Tests

## 🔧 Scheduled Tasks

```php
// App\Console\Kernel.php
$schedule->command('queue:work')->everyMinute();
$schedule->command('backup:clean')->daily();
$schedule->command('backup:run')->daily();
$schedule->command('inventory:check-expiry')->daily();
```

## 🤝 Contributing

Please read our contributing guidelines before submitting pull requests.

## 📄 License

This project is proprietary software. All rights reserved.

## 📞 Support

For technical support: support@diagnostic.com

---

Built with ❤️ for Bangladeshi Healthcare#   D r D i a g n o s t i c  
 