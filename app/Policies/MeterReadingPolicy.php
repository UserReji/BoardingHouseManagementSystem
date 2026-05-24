<?php

namespace App\Policies;

use App\Models\MeterReading;
use App\Models\User;

class MeterReadingPolicy
{
    public function before(User $user): ?bool
    {
        return $user->isManager() ? true : null;
    }

    public function view(User $user, MeterReading $meterReading): bool
    {
        return $user->id === $meterReading->user_id;
    }
}
