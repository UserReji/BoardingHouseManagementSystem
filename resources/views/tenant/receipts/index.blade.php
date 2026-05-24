@extends('layouts.tenant', ['title' => 'Receipts'])

@section('content')
<div class="page-head"><div><h1 class="page-title">Receipts</h1></div><a class="btn primary" href="{{ route('tenant.receipts.create') }}">Upload receipt</a></div>
<div class="grid grid-2">@forelse ($receipts as $receipt)<x-receipts.receipt-card :receipt="$receipt"><a class="btn" href="{{ route('tenant.receipts.show', $receipt) }}">Open</a></x-receipts.receipt-card>@empty<x-shared.empty-state />@endforelse</div>
<x-shared.pagination :items="$receipts" />
@endsection
