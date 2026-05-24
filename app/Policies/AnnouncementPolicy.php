<?php

namespace App\Policies;

use App\Models\Announcement;
use App\Models\User;

class AnnouncementPolicy
{
    public function before(User $user): ?bool
    {
        return $user->isManager() ? true : null;
    }

    public function view(User $user, Announcement $announcement): bool
    {
        return $announcement->audience === 'all' || $announcement->audience === 'tenants';
    }
}
