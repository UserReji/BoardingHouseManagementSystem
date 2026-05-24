@extends('layouts.manager', ['title' => $tenant->name])

@section('content')
    <div class="page-head">
        <div><h1 class="page-title">{{ $tenant->name }}</h1><p class="muted">{{ $tenant->email }}</p></div>
        <a class="btn" href="{{ route('manager.tenants.edit', $tenant) }}">Edit</a>
    </div>

    <div class="grid grid-2">
        <x-shared.card>
            <h3>Profile</h3>
            <p>Room: {{ $tenant->room?->name ?? 'Unassigned' }}</p>
            <p>Phone: {{ $tenant->phone ?? '-' }}</p>
            <p>Emergency: {{ $tenant->emergency_contact ?? '-' }}</p>
        </x-shared.card>
        <x-shared.card>
            <h3>Bills</h3>
            @forelse ($tenant->tenantBills as $bill)
                <p><a href="{{ route('manager.tenant-bills.show', $bill) }}">#{{ $bill->id }}</a> · PHP {{ number_format($bill->balance, 2) }}</p>
            @empty
                <p class="muted">No bills yet.</p>
            @endforelse
        </x-shared.card>
    </div>
@endsection
