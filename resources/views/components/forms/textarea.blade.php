@props(['name', 'label' => null, 'value' => null])

<div class="field">
    @if ($label)
        <x-forms.label :for="$name">{{ $label }}</x-forms.label>
    @endif
    <textarea id="{{ $name }}" name="{{ $name }}" {{ $attributes->merge(['class' => 'textarea']) }}>{{ old($name, $value) }}</textarea>
    <x-forms.error :name="$name" />
</div>
