<?php

namespace App\Enums;

enum UserRole: string
{
    case Manager = 'manager';
    case Tenant = 'tenant';

    public function label(): string
    {
        return match ($this) {
            self::Manager => 'Manager',
            self::Tenant => 'Tenant',
        };
    }

    public function homeRoute(): string
    {
        return match ($this) {
            self::Manager => 'manager.dashboard',
            self::Tenant => 'tenant.dashboard',
        };
    }
}
