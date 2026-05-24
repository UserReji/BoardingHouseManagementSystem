@extends('layouts.tenant', ['title' => 'Payments'])

@section('content')
<div class="page-head"><div><h1 class="page-title">Payments</h1><p class="muted">Submitted payment receipts.</p></div><a class="btn primary" href="{{ route('tenant.payments.create') }}">Upload payment</a></div>
<div class="grid grid-2">
@forelse ($receipts as $receipt)
<x-receipts.receipt-card :receipt="$receipt"><a class="btn" href="{{ route('tenant.payments.show', $receipt) }}">Open</a></x-receipts.receipt-card>
@empty
<x-shared.empty-state />
@endforelse
</div>
<x-shared.pagination :items="$receipts" />
@endsection
