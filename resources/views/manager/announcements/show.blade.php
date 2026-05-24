@extends('layouts.manager', ['title' => $announcement->title])

@section('content')
<div class="page-head"><div><h1 class="page-title">{{ $announcement->title }}</h1><p class="muted">Audience: {{ str($announcement->audience)->title() }}</p></div><a class="btn" href="{{ route('manager.announcements.edit', $announcement) }}">Edit</a></div>
<x-shared.card><p style="white-space:pre-line">{{ $announcement->body }}</p></x-shared.card>
@endsection
