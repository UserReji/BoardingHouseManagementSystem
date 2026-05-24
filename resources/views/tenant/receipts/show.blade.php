@extends('layouts.tenant', ['title' => 'Receipt'])

@section('content')
<div class="page-head"><div><h1 class="page-title">Receipt #{{ $receipt->id }}</h1><p class="muted">{{ $receipt->paid_at->format('M d, Y') }}</p></div><x-shared.status-pill :status="$receipt->status" /></div>
<div class="grid grid-2"><x-receipts.receipt-card :receipt="$receipt" />@if ($receipt->image_path)<img class="photo" src="{{ asset('storage/'.$receipt->image_path) }}" alt="Receipt image">@endif</div>
@endsection
