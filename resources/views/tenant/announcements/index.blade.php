@extends('layouts.tenant', ['title' => 'Announcements'])

@section('content')
<div class="page-head"><h1 class="page-title">Announcements</h1></div>
<div class="grid grid-2">
@forelse ($announcements as $announcement)
<x-announcements.announcement-card :announcement="$announcement"><a class="btn" href="{{ route('tenant.announcements.show', $announcement) }}">Read</a></x-announcements.announcement-card>
@empty
<x-shared.empty-state />
@endforelse
</div>
<x-shared.pagination :items="$announcements" />
@endsection
