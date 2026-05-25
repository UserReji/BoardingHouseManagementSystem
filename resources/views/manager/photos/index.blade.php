@extends('layouts.manager', ['title' => 'Photos'])

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">Photos</h1>
            <p class="muted">Room and property gallery.</p>
        </div>
        <a class="btn primary" href="{{ route('manager.photos.create') }}">+ Upload Photo</a>
    </div>

    <div class="grid grid-3">
    @forelse ($photos as $photo)
        <div class="card" style="padding:0;overflow:hidden">
            <img src="{{ Storage::url($photo->path) }}" alt="{{ $photo->title }}" class="photo">
            <div style="padding:12px">
                <strong>{{ $photo->title }}</strong>
                @if($photo->room)
                    <br><span class="muted">{{ $photo->room->name }}</span>
                @endif
                <div class="actions" style="margin-top:10px">
                    <a class="btn" href="{{ route('manager.photos.show', $photo) }}">View</a>
                    <button
                        class="btn danger"
                        x-data
                        x-on:click="$dispatch('open-delete-photo', { id: {{ $photo->id }}, title: '{{ addslashes($photo->title) }}' })"
                    >Delete</button>
                </div>
            </div>
        </div>
    @empty
        <x-shared.empty-state />
    @endforelse
    </div>

    <x-shared.pagination :items="$photos" />

    {{-- Delete Modal --}}
    <div
        x-data="{ open: false, photoId: null, photoTitle: '' }"
        x-on:open-delete-photo.window="open = true; photoId = $event.detail.id; photoTitle = $event.detail.title"
    >
        <div x-show="open" x-cloak style="position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:50"></div>
        <section x-show="open" x-cloak class="card" style="position:fixed;z-index:60;top:12%;left:50%;transform:translateX(-50%);width:min(92vw,480px)">
            <h2 style="margin-top:0">Delete Photo</h2>
            <p>Delete "<strong x-text="photoTitle"></strong>"? The image file will also be removed.</p>
            <form method="POST" :action="'/manager/photos/' + photoId">
                @csrf @method('DELETE')
                <div class="actions">
                    <button type="submit" class="btn danger">Yes, Delete</button>
                    <button type="button" class="btn" x-on:click="open = false">Cancel</button>
                </div>
            </form>
        </section>
    </div>
@endsection
