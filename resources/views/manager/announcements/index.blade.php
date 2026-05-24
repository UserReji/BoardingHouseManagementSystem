@extends('layouts.manager', ['title' => 'Announcements'])

@section('content')
<div class="page-head"><div><h1 class="page-title">Announcements</h1><p class="muted">Post notices for tenants and managers.</p></div><a class="btn primary" href="{{ route('manager.announcements.create') }}">New announcement</a></div>
<div class="grid grid-2">
@forelse ($announcements as $announcement)
<x-announcements.announcement-card :announcement="$announcement"><a class="btn" href="{{ route('manager.announcements.show', $announcement) }}">Open</a></x-announcements.announcement-card>
@empty
<x-shared.empty-state />
@endforelse
</div>
<x-shared.pagination :items="$announcements" />
@endsection
