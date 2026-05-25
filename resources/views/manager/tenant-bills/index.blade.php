@extends('layouts.manager', ['title' => 'Tenant Bills'])

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">Tenant Bills</h1>
            <p class="muted">Track rent, utilities, payments, and balances.</p>
        </div>
        <a class="btn primary" href="{{ route('manager.tenant-bills.create') }}">+ Add Bill</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Tenant</th>
                <th>Period</th>
                <th>Total</th>
                <th>Paid</th>
                <th>Balance</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse ($bills as $bill)
            <tr>
                <td>
                    <strong>{{ $bill->tenant?->name ?? '—' }}</strong>
                    <br><span class="muted">{{ $bill->room?->name ?? 'No room' }}</span>
                </td>
                <td>{{ $bill->billingPeriod?->name ?? '—' }}</td>
                <td>PHP {{ number_format($bill->total_amount, 2) }}</td>
                <td>PHP {{ number_format((float) $bill->amount_paid, 2) }}</td>
                <td>PHP {{ number_format($bill->balance, 2) }}</td>
                <td><x-shared.status-pill :status="$bill->status" /></td>
                <td>
                    <div class="actions">
                        <a class="btn" href="{{ route('manager.tenant-bills.show', $bill) }}">View</a>
                        <a class="btn" href="{{ route('manager.tenant-bills.edit', $bill) }}">Edit</a>
                        <button
                            class="btn danger"
                            x-data
                            x-on:click="$dispatch('open-delete-bill', { id: {{ $bill->id }} })"
                        >Delete</button>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="muted" style="text-align:center;padding:32px">No bills found.</td></tr>
        @endforelse
        </tbody>
    </table>

    <x-shared.pagination :items="$bills" />

    {{-- Delete Modal --}}
    <div
        x-data="{ open: false, billId: null }"
        x-on:open-delete-bill.window="open = true; billId = $event.detail.id"
    >
        <div x-show="open" x-cloak style="position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:50"></div>
        <section x-show="open" x-cloak class="card" style="position:fixed;z-index:60;top:12%;left:50%;transform:translateX(-50%);width:min(92vw,480px)">
            <h2 style="margin-top:0">Delete Bill</h2>
            <p>Are you sure you want to delete this bill? This action cannot be undone.</p>
            <form method="POST" :action="'/manager/tenant-bills/' + billId">
                @csrf @method('DELETE')
                <div class="actions">
                    <button type="submit" class="btn danger">Yes, Delete</button>
                    <button type="button" class="btn" x-on:click="open = false">Cancel</button>
                </div>
            </form>
        </section>
    </div>
@endsection
