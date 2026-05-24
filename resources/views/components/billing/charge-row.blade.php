@props(['label', 'amount'])

<div style="display:flex;justify-content:space-between;gap:12px;padding:8px 0;border-bottom:1px solid var(--line)">
    <span>{{ $label }}</span>
    <strong>PHP {{ number_format((float) $amount, 2) }}</strong>
</div>
