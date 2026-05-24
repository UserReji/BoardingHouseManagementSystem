@extends('layouts.manager', ['title' => 'Reports'])

@section('content')
<div class="page-head"><h1 class="page-title">Reports</h1></div>
<div class="grid grid-3">
<x-shared.card><p class="muted">Total billed</p><div class="stat">PHP {{ number_format($totalBilled, 2) }}</div></x-shared.card>
<x-shared.card><p class="muted">Total paid</p><div class="stat">PHP {{ number_format($totalPaid, 2) }}</div></x-shared.card>
<x-shared.card><p class="muted">Balance</p><div class="stat">PHP {{ number_format($totalBalance, 2) }}</div></x-shared.card>
</div>
<x-shared.card style="margin-top:16px">
<h3>Recent Bills</h3>
@foreach ($bills as $bill)<p>{{ $bill->tenant?->name }} · {{ $bill->billingPeriod?->name }} · PHP {{ number_format($bill->balance, 2) }}</p>@endforeach
</x-shared.card>
@endsection
