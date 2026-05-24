@extends('layouts.manager', ['title' => 'Manager Dashboard'])

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">Manager Dashboard</h1>
            <p class="muted">Operational overview for rooms, tenants, bills, and receipts.</p>
        </div>
    </div>

    <div class="grid grid-3">
        <x-shared.card><p class="muted">Tenants</p><div class="stat">{{ $tenantCount }}</div></x-shared.card>
        <x-shared.card><p class="muted">Rooms</p><div class="stat">{{ $roomCount }}</div></x-shared.card>
        <x-shared.card><p class="muted">Open Balance</p><div class="stat">PHP {{ number_format($openBalance, 2) }}</div></x-shared.card>
    </div>

    <div class="grid grid-2" style="margin-top:16px">
        <x-shared.card>
            <h3>Recent Receipts</h3>
            @forelse ($recentReceipts as $receipt)
                <p><a href="{{ route('manager.receipts.show', $receipt) }}">{{ $receipt->tenant?->name }}</a> · PHP {{ number_format((float) $receipt->amount, 2) }}</p>
            @empty
                <p class="muted">No receipts yet.</p>
            @endforelse
        </x-shared.card>

        <x-shared.card>
            <h3>Announcements</h3>
            @forelse ($announcements as $announcement)
                <p><a href="{{ route('manager.announcements.show', $announcement) }}">{{ $announcement->title }}</a></p>
            @empty
                <p class="muted">No announcements yet.</p>
            @endforelse
        </x-shared.card>
    </div>
@endsection
