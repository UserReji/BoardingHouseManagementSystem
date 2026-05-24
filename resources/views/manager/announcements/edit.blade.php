@extends('layouts.manager', ['title' => 'Edit Announcement'])

@section('content')
<div class="page-head"><h1 class="page-title">Edit Announcement</h1></div>
<form method="POST" action="{{ route('manager.announcements.update', $announcement) }}" class="grid">
@csrf @method('PATCH')
@include('manager.announcements.edit-fields', ['announcement' => $announcement])
<button class="btn primary" type="submit">Update announcement</button>
</form>
@endsection
