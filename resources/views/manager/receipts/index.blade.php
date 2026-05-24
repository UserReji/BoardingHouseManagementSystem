@extends('layouts.manager', ['title' => 'Receipts'])

@section('content')
<div class="page-head"><div><h1 class="page-title">Receipts</h1><p class="muted">Review tenant payment submissions.</p></div></div>
<table class="table"><thead><tr><th>Tenant</th><th>Reference</th><th>Amount</th><th>Status</th><th></th></tr></thead><tbody>
@forelse ($receipts as $receipt)
<tr><td>{{ $receipt->tenant?->name }}</td><td>{{ $receipt->reference_number ?? '-' }}</td><td>PHP {{ number_format((float) $receipt->amount, 2) }}</td><td><x-shared.status-pill :status="$receipt->status" /></td><td><a class="btn" href="{{ route('manager.receipts.show', $receipt) }}">Review</a></td></tr>
@empty
<tr><td colspan="5">No receipts found.</td></tr>
@endforelse
</tbody></table>
<x-shared.pagination :items="$receipts" />
@endsection
