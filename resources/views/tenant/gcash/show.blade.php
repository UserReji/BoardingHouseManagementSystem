@extends('layouts.tenant', ['title' => 'GCash Payment'])

@section('content')
<div class="page-head"><h1 class="page-title">GCash Payment</h1></div>
@if ($account)
<div class="grid grid-2">
<x-shared.card><h3>{{ $account->account_name }}</h3><p class="stat">{{ $account->account_number }}</p><p>{{ $account->instructions }}</p></x-shared.card>
<x-shared.card>@if ($account->qr_path)<img class="photo" src="{{ asset('storage/'.$account->qr_path) }}" alt="GCash QR">@else<p class="muted">No QR image uploaded.</p>@endif</x-shared.card>
</div>
@else
<x-shared.empty-state title="No GCash account" message="The manager has not published a payment account yet." />
@endif
@endsection
