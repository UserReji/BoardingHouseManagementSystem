@extends('layouts.manager', ['title' => 'Photos'])

@section('content')
<div class="page-head"><div><h1 class="page-title">Photos</h1><p class="muted">Room and property gallery.</p></div><a class="btn primary" href="{{ route('manager.photos.create') }}">Upload photo</a></div>
<x-gallery.photo-grid :photos="$photos" />
<x-shared.pagination :items="$photos" />
@endsection
