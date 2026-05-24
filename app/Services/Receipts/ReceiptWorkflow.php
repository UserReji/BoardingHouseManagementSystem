<?php

namespace App\Services\Receipts;

use App\Enums\ReceiptStatus;
use App\Models\Receipt;
use App\Services\Billing\BillCalculator;
use Illuminate\Support\Facades\DB;

class ReceiptWorkflow
{
    public function __construct(private readonly BillCalculator $calculator) {}

    public function approve(Receipt $receipt, int $reviewerId, ?string $notes = null): Receipt
    {
        return DB::transaction(function () use ($receipt, $reviewerId, $notes) {
            $receipt->update([
                'status' => ReceiptStatus::Approved,
                'reviewed_by' => $reviewerId,
                'reviewed_at' => now(),
                'reviewer_notes' => $notes,
            ]);

            if ($receipt->tenantBill) {
                $receipt->tenantBill->increment('amount_paid', (float) $receipt->amount);
                $this->calculator->syncStatus($receipt->tenantBill->refresh());
            }

            return $receipt->refresh();
        });
    }

    public function reject(Receipt $receipt, int $reviewerId, ?string $notes = null): Receipt
    {
        $receipt->update([
            'status' => ReceiptStatus::Rejected,
            'reviewed_by' => $reviewerId,
            'reviewed_at' => now(),
            'reviewer_notes' => $notes,
        ]);

        return $receipt->refresh();
    }
}
