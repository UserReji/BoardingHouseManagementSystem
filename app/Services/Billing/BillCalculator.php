<?php

namespace App\Services\Billing;

use App\Enums\BillStatus;
use App\Models\TenantBill;

class BillCalculator
{
    public function totals(array $data): array
    {
        $total = round(
            (float) ($data['rent_amount'] ?? 0)
            + (float) ($data['electricity_amount'] ?? 0)
            + (float) ($data['water_amount'] ?? 0)
            + (float) ($data['other_charges'] ?? 0)
            - (float) ($data['discount_amount'] ?? 0),
            2
        );

        $paid = round((float) ($data['amount_paid'] ?? 0), 2);

        return [
            'total_amount' => max(0, $total),
            'amount_paid' => $paid,
            'balance' => max(0, round($total - $paid, 2)),
        ];
    }

    public function statusFor(TenantBill|array $bill): BillStatus
    {
        $data = $bill instanceof TenantBill ? $bill->toArray() : $bill;
        $totals = $this->totals($data);

        if ($totals['balance'] <= 0 && $totals['total_amount'] > 0) {
            return BillStatus::Paid;
        }

        if ($totals['amount_paid'] > 0) {
            return BillStatus::Partial;
        }

        if (! empty($data['due_at']) && now()->startOfDay()->greaterThan($data['due_at'])) {
            return BillStatus::Overdue;
        }

        return BillStatus::Unpaid;
    }

    public function syncStatus(TenantBill $bill): TenantBill
    {
        $bill->forceFill(['status' => $this->statusFor($bill)])->save();

        return $bill->refresh();
    }
}
