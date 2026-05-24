<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\ReviewReceiptRequest;
use App\Models\Receipt;
use App\Services\Receipts\ReceiptWorkflow;

class ReceiptReviewController extends Controller
{
    public function index()
    {
        return view('manager.receipts.index', [
            'receipts' => Receipt::with('tenant', 'tenantBill')->latest()->paginate(12),
        ]);
    }

    public function show(Receipt $receipt)
    {
        return view('manager.receipts.show', [
            'receipt' => $receipt->load('tenant', 'tenantBill.billingPeriod', 'reviewer'),
        ]);
    }

    public function update(ReviewReceiptRequest $request, Receipt $receipt, ReceiptWorkflow $workflow)
    {
        if ($request->validated('decision') === 'approve') {
            $workflow->approve($receipt, $request->user()->id, $request->validated('reviewer_notes'));
        } else {
            $workflow->reject($receipt, $request->user()->id, $request->validated('reviewer_notes'));
        }

        return redirect()->route('manager.receipts.show', $receipt)->with('status', 'Receipt reviewed.');
    }
}
