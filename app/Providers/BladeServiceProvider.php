<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->hasRole($role);
        });

        Blade::if('permission', function ($permission) {
            return auth()->check() && auth()->user()->can($permission);
        });

        Blade::directive('currency', function ($expression) {
            return "<?php echo '৳ ' . number_format($expression, 2); ?>";
        });

        Blade::directive('patientId', function ($expression) {
            return "<?php echo 'P-' . str_pad($expression, 6, '0', STR_PAD_LEFT); ?>";
        });

        Blade::directive('statusBadge', function ($expression) {
            return "<?php
                \$statusColors = [
                    'pending' => 'warning',
                    'confirmed' => 'info',
                    'completed' => 'success',
                    'cancelled' => 'danger',
                    'draft' => 'secondary',
                    'verified' => 'info',
                    'approved' => 'success',
                    'released' => 'primary',
                    'paid' => 'success',
                    'unpaid' => 'danger',
                    'partial' => 'warning',
                    'refunded' => 'info',
                    'active' => 'success',
                    'inactive' => 'danger',
                ];
                \$color = \$statusColors[\$expression] ?? 'secondary';
                echo \"<span class='badge bg-{\$color}'>\" . ucfirst(\$expression) . \"</span>\";
            ?>";
        });
    }

    public function register(): void
    {
        //
    }
}