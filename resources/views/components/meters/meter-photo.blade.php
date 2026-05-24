@props(['path'])

@if ($path)
    <img class="photo" src="{{ asset('storage/'.$path) }}" alt="Meter photo">
@else
    <x-shared.empty-state title="No photo" message="No meter photo was uploaded." />
@endif
