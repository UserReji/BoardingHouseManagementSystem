<?php

namespace App\Policies;

use App\Models\TenantBill;
use App\Models\User;

class TenantBillPolicy
{
    public function before(User $user): ?bool
    {
        return $user->isManager() ? true : null;
    }

    public function view(User $user, TenantBill $tenantBill): bool
    {
        return $user->id === $tenantBill->user_id;
    }
}
