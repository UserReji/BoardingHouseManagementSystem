@extends('layouts.manager', ['title' => 'Add Meter Reading'])

@section('content')
<div class="page-head"><h1 class="page-title">Add Meter Reading</h1></div>
<form method="POST" action="{{ route('manager.meter-readings.store') }}" enctype="multipart/form-data" class="grid grid-2">
@csrf
@include('manager.meter-readings.edit-fields', ['reading' => null])
<div><button class="btn primary" type="submit">Save reading</button></div>
</form>
@endsection
