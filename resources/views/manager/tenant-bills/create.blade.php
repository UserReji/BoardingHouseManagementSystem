@extends('layouts.manager', ['title' => 'Add Bill'])

@section('content')
<div class="page-head"><h1 class="page-title">Add Bill</h1></div>
<form method="POST" action="{{ route('manager.tenant-bills.store') }}" class="grid grid-2">
@csrf
@include('manager.tenant-bills.edit-fields', ['bill' => null])
<div><button class="btn primary" type="submit">Create bill</button></div>
</form>
@endsection
