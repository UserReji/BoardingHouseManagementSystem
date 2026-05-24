@extends('layouts.manager', ['title' => 'Edit Billing Period'])

@section('content')
<div class="page-head"><h1 class="page-title">Edit Billing Period</h1></div>
<form method="POST" action="{{ route('manager.billing-periods.update', $period) }}" class="grid grid-2">
@csrf @method('PATCH')
<x-forms.input name="name" label="Name" :value="$period->name" required />
<x-forms.input name="starts_at" label="Starts" type="date" :value="$period->starts_at->toDateString()" required />
<x-forms.input name="ends_at" label="Ends" type="date" :value="$period->ends_at->toDateString()" required />
<x-forms.input name="due_at" label="Due" type="date" :value="$period->due_at->toDateString()" required />
<label><input type="checkbox" name="is_closed" value="1" @checked($period->is_closed)> Closed</label>
<div><button class="btn primary" type="submit">Update period</button></div>
</form>
@endsection
