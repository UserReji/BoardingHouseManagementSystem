@extends('layouts.manager', ['title' => 'Bill #'.$bill->id])

@section('content')
<div class="page-head"><div><h1 class="page-title">Bill #{{ $bill->id }}</h1><p class="muted">{{ $bill->tenant?->name }} · {{ $bill->billingPeriod?->name }}</p></div><a class="btn" href="{{ route('manager.tenant-bills.edit', $bill) }}">Edit</a></div>
<div class="grid grid-2">
<x-billing.bill-summary :bill="$bill" />
<x-billing.due-date-card :bill="$bill" />
</div>
<x-shared.card style="margin-top:16px">
<h3>Receipts</h3>
@forelse ($bill->receipts as $receipt)
<p><a href="{{ route('manager.receipts.show', $receipt) }}">{{ $receipt->reference_number ?? 'Receipt #'.$receipt->id }}</a> · PHP {{ number_format((float) $receipt->amount, 2) }}</p>
@empty
<p class="muted">No receipts submitted for this bill.</p>
@endforelse
</x-shared.card>
@endsection
