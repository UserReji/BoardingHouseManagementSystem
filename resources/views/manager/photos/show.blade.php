@extends('layouts.manager', ['title' => $photo->title])

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">{{ $photo->title }}</h1>
            <p class="muted">{{ $photo->room?->name ?? 'Common area' }} · Uploaded by {{ $photo->uploader?->name ?? '—' }}</p>
        </div>
        <div class="actions">
            <a class="btn" href="{{ route('manager.photos.index') }}">← Back</a>
            <button class="btn danger" x-data x-on:click="$dispatch('open-delete-photo-show')">Delete Photo</button>
        </div>
    </div>

    @if ($photo->path)
        <img class="photo" src="{{ asset('storage/'.$photo->path) }}" alt="{{ $photo->title }}">
    @endif

    <x-shared.card style="margin-top:16px">
        <p>{{ $photo->description ?? 'No description.' }}</p>
        @if($photo->taken_at)
            <p class="muted" style="font-size:13px">Taken: {{ $photo->taken_at->format('M d, Y') }}</p>
        @endif
        @if($photo->is_featured)
            <x-shared.badge tone="info">⭐ Featured</x-shared.badge>
        @endif
    </x-shared.card>

    <div x-data="{ open: false }" x-on:open-delete-photo-show.window="open = true">
        <div x-show="open" x-cloak style="position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:50"></div>
        <section x-show="open" x-cloak class="card" style="position:fixed;z-index:60;top:12%;left:50%;transform:translateX(-50%);width:min(92vw,480px)">
            <h2 style="margin-top:0">Delete Photo</h2>
            <p>Delete "<strong>{{ $photo->title }}</strong>"? The image file will also be removed permanently.</p>
            <form method="POST" action="{{ route('manager.photos.destroy', $photo) }}">
                @csrf @method('DELETE')
                <div class="actions">
                    <button type="submit" class="btn danger">Yes, Delete</button>
                    <button type="button" class="btn" x-on:click="open = false">Cancel</button>
                </div>
            </form>
        </section>
    </div>
@endsection
