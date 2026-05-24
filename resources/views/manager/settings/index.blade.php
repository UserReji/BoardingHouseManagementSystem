@extends('layouts.manager', ['title' => 'Settings'])

@section('content')
<div class="page-head"><h1 class="page-title">Settings</h1></div>
<x-shared.card>
<h3>{{ $user->name }}</h3>
<p class="muted">{{ $user->email }}</p>
<p>Role: {{ $user->role->label() }}</p>
</x-shared.card>
@endsection
