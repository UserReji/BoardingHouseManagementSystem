<?php

namespace App\Policies;

use App\Models\BillingPeriod;
use App\Models\User;

class BillingPeriodPolicy
{
    public function before(User $user): ?bool
    {
        return $user->isManager() ? true : null;
    }

    public function view(User $user, BillingPeriod $billingPeriod): bool
    {
        return $user->isTenant();
    }
}
