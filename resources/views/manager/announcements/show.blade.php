@extends('layouts.manager', ['title' => $announcement->title])

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">{{ $announcement->title }}</h1>
            <p class="muted">Audience: {{ str($announcement->audience)->title() }} · Posted by {{ $announcement->creator?->name ?? 'System' }}</p>
        </div>
        <div class="actions">
            <a class="btn" href="{{ route('manager.announcements.index') }}">← Back</a>
            <a class="btn" href="{{ route('manager.announcements.edit', $announcement) }}">Edit</a>
            <button class="btn danger" x-data x-on:click="$dispatch('open-delete-ann')">Delete</button>
        </div>
    </div>

    <x-shared.card>
        @if($announcement->is_pinned)
            <x-shared.badge tone="warning" style="margin-bottom:10px">📌 Pinned</x-shared.badge>
        @endif
        <p style="white-space:pre-line">{{ $announcement->body }}</p>
        <p class="muted" style="font-size:13px;margin-top:16px">
            Published: {{ $announcement->published_at?->format('M d, Y g:i A') ?? 'Not published yet' }}
            @if($announcement->expires_at)
                · Expires: {{ $announcement->expires_at->format('M d, Y') }}
            @endif
        </p>
    </x-shared.card>

    <div x-data="{ open: false }" x-on:open-delete-ann.window="open = true">
        <div x-show="open" x-cloak style="position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:50"></div>
        <section x-show="open" x-cloak class="card" style="position:fixed;z-index:60;top:12%;left:50%;transform:translateX(-50%);width:min(92vw,480px)">
            <h2 style="margin-top:0">Delete Announcement</h2>
            <p>Delete "<strong>{{ $announcement->title }}</strong>"? This cannot be undone.</p>
            <form method="POST" action="{{ route('manager.announcements.destroy', $announcement) }}">
                @csrf @method('DELETE')
                <div class="actions">
                    <button type="submit" class="btn danger">Yes, Delete</button>
                    <button type="button" class="btn" x-on:click="open = false">Cancel</button>
                </div>
            </form>
        </section>
    </div>
@endsection
