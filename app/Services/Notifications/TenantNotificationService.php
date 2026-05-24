<?php

namespace App\Services\Notifications;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class TenantNotificationService
{
    public function log(User $tenant, string $message, array $context = []): void
    {
        Log::info('Tenant notification', [
            'tenant_id' => $tenant->id,
            'tenant_email' => $tenant->email,
            'message' => $message,
            'context' => $context,
        ]);
    }
}
