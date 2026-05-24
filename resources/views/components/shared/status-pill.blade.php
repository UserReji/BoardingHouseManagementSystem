@props(['status'])

@php
    $tone = method_exists($status, 'tone') ? $status->tone() : 'neutral';
    $label = method_exists($status, 'label') ? $status->label() : str($status)->title();
@endphp

<x-shared.badge :tone="$tone">{{ $label }}</x-shared.badge>
