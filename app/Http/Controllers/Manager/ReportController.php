<?php

namespace App\Http\Controllers\Manager;

use App\Enums\BillStatus;
use App\Enums\ReceiptStatus;
use App\Http\Controllers\Controller;
use App\Models\Receipt;
use App\Models\TenantBill;

class ReportController extends Controller
{
    public function index()
    {
        $bills = TenantBill::with('tenant', 'billingPeriod')->latest()->get();

        return view('manager.reports.index', [
            'totalBilled' => $bills->sum('total_amount'),
            'totalPaid' => $bills->sum('amount_paid'),
            'totalBalance' => $bills->sum('balance'),
            'paidCount' => $bills->where('status', BillStatus::Paid)->count(),
            'pendingReceipts' => Receipt::where('status', ReceiptStatus::Pending)->count(),
            'bills' => $bills->take(20),
        ]);
    }
}
