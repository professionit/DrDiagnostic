<?php

namespace App\Enums;

enum UserRole: string
{
    case SUPER_ADMIN = 'super_admin';
    case BRANCH_ADMIN = 'branch_admin';
    case RECEPTIONIST = 'receptionist';
    case DOCTOR = 'doctor';
    case PATHOLOGIST = 'pathologist';
    case ACCOUNTANT = 'accountant';

    public function label(): string
    {
        return match($this) {
            self::SUPER_ADMIN => 'Super Admin',
            self::BRANCH_ADMIN => 'Branch Admin',
            self::RECEPTIONIST => 'Receptionist',
            self::DOCTOR => 'Doctor',
            self::PATHOLOGIST => 'Pathologist',
            self::ACCOUNTANT => 'Accountant',
        };
    }

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}