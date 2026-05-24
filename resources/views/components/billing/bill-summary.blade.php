@props(['bill'])

<x-shared.card>
    <h3>Bill Summary</h3>
    <x-billing.charge-row label="Rent" :amount="$bill->rent_amount" />
    <x-billing.charge-row label="Electricity" :amount="$bill->electricity_amount" />
    <x-billing.charge-row label="Water" :amount="$bill->water_amount" />
    <x-billing.charge-row label="Other charges" :amount="$bill->other_charges" />
    <x-billing.charge-row label="Discount" :amount="-$bill->discount_amount" />
    <x-billing.charge-row label="Paid" :amount="-$bill->amount_paid" />
    <div style="display:flex;justify-content:space-between;margin-top:12px;font-size:20px">
        <span>Balance</span>
        <strong>PHP {{ number_format($bill->balance, 2) }}</strong>
    </div>
</x-shared.card>
