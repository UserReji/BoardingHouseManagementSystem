@props(['announcement'])

<x-shared.card>
    <div class="page-head">
        <div>
            <h3>{{ $announcement->title }}</h3>
            <p class="muted">{{ optional($announcement->published_at)->format('M d, Y') ?? 'Draft' }}</p>
        </div>
        @if ($announcement->is_pinned)
            <x-shared.badge tone="info">Pinned</x-shared.badge>
        @endif
    </div>
    <p>{{ str($announcement->body)->limit(180) }}</p>
    {{ $slot }}
</x-shared.card>
