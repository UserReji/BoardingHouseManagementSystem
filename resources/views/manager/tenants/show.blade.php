@extends('layouts.manager', ['title' => $tenant->name])

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">{{ $tenant->name }}</h1>
            <p class="muted">{{ $tenant->email }}</p>
        </div>
        <div class="actions">
            <a class="btn" href="{{ route('manager.tenants.index') }}">← Back</a>
            <a class="btn" href="{{ route('manager.tenants.edit', $tenant) }}">Edit</a>
            @if($tenant->is_active)
                <button
                    class="btn danger"
                    x-data
                    x-on:click="$dispatch('open-archive-tenant-show')"
                >Archive Tenant</button>
            @else
                <form method="POST" action="{{ route('manager.tenants.restore', $tenant) }}" style="display:inline">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn primary">Restore Tenant</button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid grid-2">
        <x-shared.card>
            <h3 style="margin-top:0">Profile</h3>
            <p><span class="muted">Room:</span> {{ $tenant->room?->name ?? 'Unassigned' }}</p>
            <p><span class="muted">Phone:</span> {{ $tenant->phone ?? '—' }}</p>
            <p><span class="muted">Emergency:</span> {{ $tenant->emergency_contact ?? '—' }}</p>
            <p><span class="muted">Move-in:</span> {{ $tenant->move_in_date?->format('M d, Y') ?? '—' }}</p>
            @if(!$tenant->is_active)
                <p><span class="muted">Move-out:</span> {{ $tenant->move_out_date?->format('M d, Y') ?? '—' }}</p>
                <p><span class="muted">Reason:</span> {{ $tenant->deactivation_reason ?? '—' }}</p>
            @endif
            <p>
                <x-shared.badge :tone="$tenant->is_active ? 'success' : 'muted'">
                    {{ $tenant->is_active ? 'Active' : 'Archived' }}
                </x-shared.badge>
            </p>
        </x-shared.card>

        <x-shared.card>
            <h3 style="margin-top:0">Bills</h3>
            @forelse ($tenant->tenantBills as $bill)
                <p>
                    <a href="{{ route('manager.tenant-bills.show', $bill) }}">#{{ $bill->id }} — {{ $bill->billingPeriod?->name }}</a>
                    <br><span class="muted">Balance: PHP {{ number_format($bill->balance, 2) }}</span>
                </p>
            @empty
                <p class="muted">No bills yet.</p>
            @endforelse
        </x-shared.card>
    </div>

    {{-- Archive Modal (from show page) --}}
    @if($tenant->is_active)
    <div
        x-data="{ open: false }"
        x-on:open-archive-tenant-show.window="open = true"
    >
        <div x-show="open" x-cloak style="position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:50"></div>
        <section x-show="open" x-cloak class="card" style="position:fixed;z-index:60;top:12%;left:50%;transform:translateX(-50%);width:min(92vw,480px)">
            <h2 style="margin-top:0">Archive Tenant</h2>
            <p>Archive <strong>{{ $tenant->name }}</strong>? Their billing history and receipts will be preserved.</p>
            <form method="POST" action="{{ route('manager.tenants.destroy', $tenant) }}">
                @csrf @method('DELETE')
                <div class="field" style="margin-bottom:12px">
                    <label class="label">Move-out Date</label>
                    <input class="input" type="date" name="move_out_date" value="{{ now()->toDateString() }}">
                </div>
                <div class="field" style="margin-bottom:18px">
                    <label class="label">Reason</label>
                    <input class="input" type="text" name="deactivation_reason" placeholder="e.g. Moved out, Lease ended…">
                </div>
                <div class="actions">
                    <button type="submit" class="btn danger">Confirm Archive</button>
                    <button type="button" class="btn" x-on:click="open = false">Cancel</button>
                </div>
            </form>
        </section>
    </div>
    @endif
@endsection
