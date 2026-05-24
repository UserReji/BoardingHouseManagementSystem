@extends('layouts.tenant', ['title' => 'Payment Receipt'])

@section('content')
<div class="page-head"><div><h1 class="page-title">Payment Receipt</h1><p class="muted">{{ $receipt->reference_number ?? 'No reference' }}</p></div><x-shared.status-pill :status="$receipt->status" /></div>
<div class="grid grid-2"><x-receipts.receipt-card :receipt="$receipt" />@if ($receipt->image_path)<img class="photo" src="{{ asset('storage/'.$receipt->image_path) }}" alt="Receipt image">@endif</div>
@endsection
