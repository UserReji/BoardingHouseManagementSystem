<?php

namespace App\Http\Controllers\Tenant;

use App\Enums\ReceiptStatus;
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\TenantBill;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $tenant = $request->user();

        return view('tenant.dashboard', [
            'tenant' => $tenant->load('room'),
            'latestBill' => TenantBill::with('billingPeriod')->where('user_id', $tenant->id)->latest()->first(),
            'balance' => TenantBill::where('user_id', $tenant->id)->get()->sum('balance'),
            'pendingReceipts' => $tenant->receipts()->where('status', ReceiptStatus::Pending)->count(),
            'announcements' => Announcement::visibleToTenants()->latest('published_at')->take(5)->get(),
        ]);
    }
}
