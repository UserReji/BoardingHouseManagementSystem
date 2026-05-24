<?php

namespace App\Policies;

use App\Models\Photo;
use App\Models\User;

class PhotoPolicy
{
    public function before(User $user): ?bool
    {
        return $user->isManager() ? true : null;
    }

    public function view(User $user, Photo $photo): bool
    {
        return in_array($photo->visibility, ['public', 'tenants'], true);
    }
}
