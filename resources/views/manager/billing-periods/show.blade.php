@extends('layouts.manager', ['title' => $period->name])

@section('content')
<div class="page-head"><div><h1 class="page-title">{{ $period->name }}</h1><p class="muted">{{ $period->starts_at->format('M d') }} - {{ $period->ends_at->format('M d, Y') }}</p></div><a class="btn" href="{{ route('manager.billing-periods.edit', $period) }}">Edit</a></div>
<x-shared.card>
<h3>Bills in this period</h3>
@forelse ($period->tenantBills as $bill)
<p><a href="{{ route('manager.tenant-bills.show', $bill) }}">Bill #{{ $bill->id }}</a> · {{ $bill->tenant?->name }} · PHP {{ number_format($bill->balance, 2) }}</p>
@empty
<p class="muted">No bills yet.</p>
@endforelse
</x-shared.card>
@endsection
