<?php

namespace App\Enums;

enum ReportStatus: string
{
    case DRAFT = 'draft';
    case VERIFIED = 'verified';
    case APPROVED = 'approved';
    case RELEASED = 'released';

    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Draft',
            self::VERIFIED => 'Verified',
            self::APPROVED => 'Approved',
            self::RELEASED => 'Released',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::DRAFT => 'secondary',
            self::VERIFIED => 'info',
            self::APPROVED => 'success',
            self::RELEASED => 'primary',
        };
    }
}