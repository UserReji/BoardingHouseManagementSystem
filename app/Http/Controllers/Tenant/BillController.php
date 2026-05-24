<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\TenantBill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index(Request $request)
    {
        return view('tenant.bills.index', [
            'bills' => TenantBill::with('billingPeriod')->where('user_id', $request->user()->id)->latest()->paginate(12),
        ]);
    }

    public function show(Request $request, TenantBill $bill)
    {
        abort_unless($bill->user_id === $request->user()->id, 403);

        return view('tenant.bills.show', ['bill' => $bill->load('billingPeriod', 'receipts')]);
    }
}
