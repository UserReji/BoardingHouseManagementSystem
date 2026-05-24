<?php

namespace App\Enums;

enum BillStatus: string
{
    case Draft = 'draft';
    case Unpaid = 'unpaid';
    case Partial = 'partial';
    case Paid = 'paid';
    case Overdue = 'overdue';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return str($this->value)->replace('_', ' ')->title()->toString();
    }

    public function tone(): string
    {
        return match ($this) {
            self::Paid => 'success',
            self::Partial => 'warning',
            self::Overdue => 'danger',
            self::Cancelled => 'muted',
            self::Draft => 'info',
            self::Unpaid => 'neutral',
        };
    }
}
