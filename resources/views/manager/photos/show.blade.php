@extends('layouts.manager', ['title' => $photo->title])

@section('content')
<div class="page-head"><div><h1 class="page-title">{{ $photo->title }}</h1><p class="muted">{{ $photo->room?->name ?? 'Common area' }}</p></div></div>
@if ($photo->path)<img class="photo" src="{{ asset('storage/'.$photo->path) }}" alt="{{ $photo->title }}">@endif
<x-shared.card style="margin-top:16px"><p>{{ $photo->description ?? 'No description.' }}</p></x-shared.card>
@endsection
