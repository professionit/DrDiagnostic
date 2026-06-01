<?php

namespace App\Enums;

enum SampleStatus: string
{
    case COLLECTED = 'collected';
    case RECEIVED = 'received';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match($this) {
            self::COLLECTED => 'Sample Collected',
            self::RECEIVED => 'Sample Received',
            self::PROCESSING => 'Processing',
            self::COMPLETED => 'Completed',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::COLLECTED => 'warning',
            self::RECEIVED => 'info',
            self::PROCESSING => 'primary',
            self::COMPLETED => 'success',
        };
    }
}