@extends('layouts.tenant', ['title' => $announcement->title])

@section('content')
<div class="page-head"><div><h1 class="page-title">{{ $announcement->title }}</h1><p class="muted">{{ optional($announcement->published_at)->format('M d, Y') }}</p></div></div>
<x-shared.card><p style="white-space:pre-line">{{ $announcement->body }}</p></x-shared.card>
@endsection
