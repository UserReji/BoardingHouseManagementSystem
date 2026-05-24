@extends('layouts.manager', ['title' => 'Add Billing Period'])

@section('content')
<div class="page-head"><h1 class="page-title">Add Billing Period</h1></div>
<form method="POST" action="{{ route('manager.billing-periods.store') }}" class="grid grid-2">
@csrf
<x-forms.input name="name" label="Name" required />
<x-forms.input name="starts_at" label="Starts" type="date" required />
<x-forms.input name="ends_at" label="Ends" type="date" required />
<x-forms.input name="due_at" label="Due" type="date" required />
<label><input type="checkbox" name="is_closed" value="1"> Closed</label>
<div><button class="btn primary" type="submit">Create period</button></div>
</form>
@endsection
