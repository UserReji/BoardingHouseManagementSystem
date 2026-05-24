@extends('layouts.manager', ['title' => 'Billing Periods'])

@section('content')
<div class="page-head"><div><h1 class="page-title">Billing Periods</h1><p class="muted">Monthly billing windows and due dates.</p></div><a class="btn primary" href="{{ route('manager.billing-periods.create') }}">Add period</a></div>
<table class="table"><thead><tr><th>Name</th><th>Dates</th><th>Due</th><th>Bills</th><th></th></tr></thead><tbody>
@forelse ($periods as $period)
<tr><td><a href="{{ route('manager.billing-periods.show', $period) }}">{{ $period->name }}</a></td><td>{{ $period->starts_at->format('M d') }} - {{ $period->ends_at->format('M d, Y') }}</td><td>{{ $period->due_at->format('M d, Y') }}</td><td>{{ $period->tenant_bills_count }}</td><td><a class="btn" href="{{ route('manager.billing-periods.edit', $period) }}">Edit</a></td></tr>
@empty
<tr><td colspan="5">No billing periods found.</td></tr>
@endforelse
</tbody></table>
<x-shared.pagination :items="$periods" />
@endsection
