<?php

namespace App\Policies;

use App\Models\Receipt;
use App\Models\User;

class ReceiptPolicy
{
    public function before(User $user): ?bool
    {
        return $user->isManager() ? true : null;
    }

    public function view(User $user, Receipt $receipt): bool
    {
        return $user->id === $receipt->user_id;
    }
}
