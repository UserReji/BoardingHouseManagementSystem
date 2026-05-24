@props(['name', 'label' => null, 'type' => 'text', 'value' => null])

<div class="field">
    @if ($label)
        <x-forms.label :for="$name">{{ $label }}</x-forms.label>
    @endif
    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($name, $value) }}" {{ $attributes->merge(['class' => 'input']) }}>
    <x-forms.error :name="$name" />
</div>
