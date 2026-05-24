@extends('layouts.tenant', ['title' => 'Gallery'])

@section('content')
<div class="page-head"><h1 class="page-title">Gallery</h1></div>
<div class="grid grid-3">
@forelse ($photos as $photo)
<x-shared.card>
@if ($photo->path)<img class="photo" src="{{ asset('storage/'.$photo->path) }}" alt="{{ $photo->title }}">@endif
<h3>{{ $photo->title }}</h3>
<p class="muted">{{ $photo->room?->name ?? 'Common area' }}</p>
<a class="btn" href="{{ route('tenant.gallery.show', $photo) }}">Open</a>
</x-shared.card>
@empty
<x-shared.empty-state />
@endforelse
</div>
<x-shared.pagination :items="$photos" />
@endsection
