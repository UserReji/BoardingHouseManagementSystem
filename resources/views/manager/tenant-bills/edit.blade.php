@extends('layouts.manager', ['title' => 'Edit Bill'])

@section('content')
<div class="page-head"><h1 class="page-title">Edit Bill #{{ $bill->id }}</h1></div>
<form method="POST" action="{{ route('manager.tenant-bills.update', $bill) }}" class="grid grid-2">
@csrf @method('PATCH')
@include('manager.tenant-bills.edit-fields', ['bill' => $bill])
<div><button class="btn primary" type="submit">Update bill</button></div>
</form>
@endsection
