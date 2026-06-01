<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case CASH = 'cash';
    case CARD = 'card';
    case BKASH = 'bkash';
    case NAGAD = 'nagad';
    case ROCKET = 'rocket';

    public function label(): string
    {
        return match($this) {
            self::CASH => 'Cash',
            self::CARD => 'Card',
            self::BKASH => 'bKash',
            self::NAGAD => 'Nagad',
            self::ROCKET => 'Rocket',
        };
    }
}