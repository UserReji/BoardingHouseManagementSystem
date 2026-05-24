@extends('layouts.tenant', ['title' => 'Tenant Dashboard'])

@section('content')
<div class="page-head"><div><h1 class="page-title">Tenant Dashboard</h1><p class="muted">Welcome back, {{ $tenant->name }}.</p></div><a class="btn primary" href="{{ route('tenant.payments.create') }}">Upload payment</a></div>
<div class="grid grid-3">
<x-shared.card><p class="muted">Room</p><div class="stat">{{ $tenant->room?->code ?? '-' }}</div></x-shared.card>
<x-shared.card><p class="muted">Balance</p><div class="stat">PHP {{ number_format($balance, 2) }}</div></x-shared.card>
<x-shared.card><p class="muted">Pending receipts</p><div class="stat">{{ $pendingReceipts }}</div></x-shared.card>
</div>
<div class="grid grid-2" style="margin-top:16px">
@if ($latestBill)<x-billing.bill-summary :bill="$latestBill" />@else<x-shared.empty-state title="No bill yet" message="Your bills will appear here." />@endif
<x-shared.card><h3>Announcements</h3>@forelse ($announcements as $announcement)<p><a href="{{ route('tenant.announcements.show', $announcement) }}">{{ $announcement->title }}</a></p>@empty<p class="muted">No announcements.</p>@endforelse</x-shared.card>
</div>
@endsection
