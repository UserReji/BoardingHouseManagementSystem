@props(['name', 'label' => 'Upload file'])

<div class="field">
    <x-forms.label :for="$name">{{ $label }}</x-forms.label>
    <input id="{{ $name }}" name="{{ $name }}" type="file" {{ $attributes->merge(['class' => 'input']) }}>
    <x-forms.error :name="$name" />
</div>
