@extends('layouts.manager', ['title' => 'Edit Meter Reading'])

@section('content')
<div class="page-head"><h1 class="page-title">Edit Meter Reading</h1></div>
<form method="POST" action="{{ route('manager.meter-readings.update', $reading) }}" enctype="multipart/form-data" class="grid grid-2">
@csrf @method('PATCH')
@include('manager.meter-readings.edit-fields', ['reading' => $reading])
<div><button class="btn primary" type="submit">Update reading</button></div>
</form>
@endsection
