@props(['reading'])

<x-shared.card>
    <h3>{{ $reading->type->label() }}</h3>
    <p class="stat">{{ number_format($reading->usage, 2) }} {{ $reading->type->unit() }}</p>
    <p class="muted">Amount: PHP {{ number_format((float) $reading->amount, 2) }}</p>
</x-shared.card>
