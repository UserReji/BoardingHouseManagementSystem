@props(['name', 'label' => null, 'value' => null])

<div class="field">
    @if ($label)
        <x-forms.label :for="$name">{{ $label }}</x-forms.label>
    @endif
    <select id="{{ $name }}" name="{{ $name }}" {{ $attributes->merge(['class' => 'select']) }}>
        {{ $slot }}
    </select>
    <x-forms.error :name="$name" />
</div>
