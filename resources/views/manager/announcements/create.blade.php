@extends('layouts.manager', ['title' => 'New Announcement'])

@section('content')
<div class="page-head"><h1 class="page-title">New Announcement</h1></div>
<form method="POST" action="{{ route('manager.announcements.store') }}" class="grid">
@csrf
@include('manager.announcements.edit-fields', ['announcement' => null])
<button class="btn primary" type="submit">Post announcement</button>
</form>
@endsection
