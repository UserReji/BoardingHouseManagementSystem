@props(['photos'])

<div class="grid grid-3">
    @forelse ($photos as $photo)
        <x-shared.card>
            @if ($photo->path)
                <img class="photo" src="{{ asset('storage/'.$photo->path) }}" alt="{{ $photo->title }}">
            @endif
            <h3>{{ $photo->title }}</h3>
            <p class="muted">{{ $photo->room?->name ?? 'Common area' }}</p>
            {{ $slot }}
        </x-shared.card>
    @empty
        <x-shared.empty-state />
    @endforelse
</div>
