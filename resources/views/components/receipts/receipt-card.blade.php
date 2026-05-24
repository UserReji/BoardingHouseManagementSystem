@props(['receipt'])

<x-shared.card>
    <div class="page-head">
        <div>
            <h3>PHP {{ number_format((float) $receipt->amount, 2) }}</h3>
            <p class="muted">{{ $receipt->reference_number ?? 'No reference' }} · {{ $receipt->paid_at->format('M d, Y') }}</p>
        </div>
        <x-shared.status-pill :status="$receipt->status" />
    </div>
    {{ $slot }}
</x-shared.card>
