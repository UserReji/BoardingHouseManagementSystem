@props(['variant' => ''])

<button {{ $attributes->merge(['class' => trim('btn '.$variant)]) }}>
    {{ $slot }}
</button>
