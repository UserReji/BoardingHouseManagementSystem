@extends('layouts.tenant', ['title' => 'Bill #'.$bill->id])

@section('content')
<div class="page-head"><div><h1 class="page-title">Bill #{{ $bill->id }}</h1><p class="muted">{{ $bill->billingPeriod?->name }}</p></div><a class="btn primary" href="{{ route('tenant.payments.create') }}">Pay</a></div>
<div class="grid grid-2"><x-billing.bill-summary :bill="$bill" /><x-billing.due-date-card :bill="$bill" /></div>
<x-shared.card style="margin-top:16px"><h3>Receipts</h3>@forelse ($bill->receipts as $receipt)<p>{{ $receipt->reference_number ?? 'Receipt #'.$receipt->id }} · <x-shared.status-pill :status="$receipt->status" /></p>@empty<p class="muted">No receipts yet.</p>@endforelse</x-shared.card>
@endsection
