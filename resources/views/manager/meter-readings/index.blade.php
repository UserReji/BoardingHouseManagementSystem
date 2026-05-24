@extends('layouts.manager', ['title' => 'Meter Readings'])

@section('content')
<div class="page-head"><div><h1 class="page-title">Meter Readings</h1><p class="muted">Electricity and water readings per tenant.</p></div><a class="btn primary" href="{{ route('manager.meter-readings.create') }}">Add reading</a></div>
<table class="table"><thead><tr><th>Tenant</th><th>Type</th><th>Usage</th><th>Amount</th><th></th></tr></thead><tbody>
@forelse ($readings as $reading)
<tr><td>{{ $reading->tenant?->name }}</td><td>{{ $reading->type->label() }}</td><td>{{ number_format($reading->usage, 2) }} {{ $reading->type->unit() }}</td><td>PHP {{ number_format((float) $reading->amount, 2) }}</td><td><a class="btn" href="{{ route('manager.meter-readings.show', $reading) }}">Open</a></td></tr>
@empty
<tr><td colspan="5">No readings found.</td></tr>
@endforelse
</tbody></table>
<x-shared.pagination :items="$readings" />
@endsection
