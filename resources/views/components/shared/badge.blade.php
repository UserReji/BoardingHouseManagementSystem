@props(['tone' => ''])

<span {{ $attributes->merge(['class' => trim('badge '.$tone)]) }}>
    {{ $slot }}
</span>
