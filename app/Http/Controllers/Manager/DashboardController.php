<?php

namespace App\Http\Controllers\Manager;

use App\Enums\BillStatus;
use App\Enums\ReceiptStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Receipt;
use App\Models\Room;
use App\Models\TenantBill;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('manager.dashboard', [
            'tenantCount' => User::where('role', UserRole::Tenant)->count(),
            'roomCount' => Room::count(),
            'pendingReceipts' => Receipt::where('status', ReceiptStatus::Pending)->count(),
            'openBalance' => TenantBill::whereNotIn('status', [BillStatus::Paid, BillStatus::Cancelled])->get()->sum('balance'),
            'recentReceipts' => Receipt::with('tenant', 'tenantBill')->latest()->take(5)->get(),
            'overdueBills' => TenantBill::with('tenant', 'billingPeriod')->where('status', BillStatus::Overdue)->latest()->take(5)->get(),
            'announcements' => Announcement::latest()->take(5)->get(),
        ]);
    }
}
