@props(['bill'])

<x-shared.card>
    <h3>Due Date</h3>
    <p class="stat">{{ optional($bill->due_at)->format('M d') ?? 'Unset' }}</p>
    <x-billing.payment-status :status="$bill->status" />
</x-shared.card>
