@extends('layouts.manager', ['title' => 'Tenant Bills'])

@section('content')
<div class="page-head"><div><h1 class="page-title">Tenant Bills</h1><p class="muted">Track rent, utilities, payments, and balances.</p></div><a class="btn primary" href="{{ route('manager.tenant-bills.create') }}">Add bill</a></div>
<table class="table"><thead><tr><th>Tenant</th><th>Period</th><th>Total</th><th>Balance</th><th>Status</th><th></th></tr></thead><tbody>
@forelse ($bills as $bill)
<tr><td>{{ $bill->tenant?->name }}</td><td>{{ $bill->billingPeriod?->name }}</td><td>PHP {{ number_format($bill->total_amount, 2) }}</td><td>PHP {{ number_format($bill->balance, 2) }}</td><td><x-shared.status-pill :status="$bill->status" /></td><td><a class="btn" href="{{ route('manager.tenant-bills.show', $bill) }}">Open</a></td></tr>
@empty
<tr><td colspan="6">No bills found.</td></tr>
@endforelse
</tbody></table>
<x-shared.pagination :items="$bills" />
@endsection
