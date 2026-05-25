@extends('layouts.manager', ['title' => 'Announcements'])

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">Announcements</h1>
            <p class="muted">Post notices for tenants and managers.</p>
        </div>
        <a class="btn primary" href="{{ route('manager.announcements.create') }}">+ New Announcement</a>
    </div>

    <div class="grid grid-2">
    @forelse ($announcements as $announcement)
        <x-announcements.announcement-card :announcement="$announcement">
            <div class="actions" style="margin-top:12px">
                <a class="btn" href="{{ route('manager.announcements.show', $announcement) }}">Open</a>
                <a class="btn" href="{{ route('manager.announcements.edit', $announcement) }}">Edit</a>
                <button
                    class="btn danger"
                    x-data
                    x-on:click="$dispatch('open-delete-announcement', { id: {{ $announcement->id }}, title: '{{ addslashes($announcement->title) }}' })"
                >Delete</button>
            </div>
        </x-announcements.announcement-card>
    @empty
        <x-shared.empty-state />
    @endforelse
    </div>

    <x-shared.pagination :items="$announcements" />

    {{-- Delete Confirmation Modal --}}
    <div
        x-data="{ open: false, announcementId: null, announcementTitle: '' }"
        x-on:open-delete-announcement.window="open = true; announcementId = $event.detail.id; announcementTitle = $event.detail.title"
    >
        <div x-show="open" x-cloak style="position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:50"></div>
        <section x-show="open" x-cloak class="card" style="position:fixed;z-index:60;top:12%;left:50%;transform:translateX(-50%);width:min(92vw,480px)">
            <h2 style="margin-top:0">Delete Announcement</h2>
            <p>Delete "<strong x-text="announcementTitle"></strong>"? This cannot be undone.</p>
            <form method="POST" :action="'/manager/announcements/' + announcementId">
                @csrf @method('DELETE')
                <div class="actions">
                    <button type="submit" class="btn danger">Yes, Delete</button>
                    <button type="button" class="btn" x-on:click="open = false">Cancel</button>
                </div>
            </form>
        </section>
    </div>
@endsection
