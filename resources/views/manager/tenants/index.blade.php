@extends('layouts.manager', ['title' => 'Tenants'])

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">Tenants</h1>
            <p class="muted">Active renters — rooms, contacts, and status.</p>
        </div>
        <div class="actions">
            <a class="btn" href="{{ route('manager.tenants.archived') }}">
                Archived
            </a>
            <a class="btn primary" href="{{ route('manager.tenants.create') }}">+ Add Tenant</a>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Room</th>
                <th>Phone</th>
                <th>Move-in</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse ($tenants as $tenant)
            <tr>
                <td>
                    <a href="{{ route('manager.tenants.show', $tenant) }}"><strong>{{ $tenant->name }}</strong></a>
                    <br><span class="muted">{{ $tenant->email }}</span>
                </td>
                <td>{{ $tenant->room?->name ?? '—' }}</td>
                <td>{{ $tenant->phone ?? '—' }}</td>
                <td>{{ $tenant->move_in_date?->format('M d, Y') ?? '—' }}</td>
                <td>
                    <x-shared.badge :tone="$tenant->is_active ? 'success' : 'muted'">
                        {{ $tenant->is_active ? 'Active' : 'Inactive' }}
                    </x-shared.badge>
                </td>
                <td>
                    <div class="actions">
                        <a class="btn" href="{{ route('manager.tenants.edit', $tenant) }}">Edit</a>
                        {{-- Archive (deactivate) button --}}
                        <button
                            class="btn danger"
                            x-data
                            x-on:click="$dispatch('open-archive-tenant', { id: {{ $tenant->id }}, name: '{{ addslashes($tenant->name) }}' })"
                        >Archive</button>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="muted" style="text-align:center;padding:32px">No active tenants found.</td></tr>
        @endforelse
        </tbody>
    </table>

    <x-shared.pagination :items="$tenants" />

    {{-- Archive / Deactivate Confirmation Modal --}}
    <div
        x-data="{ open: false, tenantId: null, tenantName: '' }"
        x-on:open-archive-tenant.window="open = true; tenantId = $event.detail.id; tenantName = $event.detail.name"
    >
        <div x-show="open" x-cloak style="position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:50"></div>
        <section x-show="open" x-cloak class="card" style="position:fixed;z-index:60;top:12%;left:50%;transform:translateX(-50%);width:min(92vw,480px)">
            <h2 style="margin-top:0">Archive Tenant</h2>
            <p>You are about to archive <strong x-text="tenantName"></strong>. Their billing history and receipts will be preserved in the archived tenants list.</p>

            <form method="POST" :action="'/manager/tenants/' + tenantId">
                @csrf
                @method('DELETE')
                <div class="field" style="margin-bottom:12px">
                    <label class="label" for="move_out_date">Move-out Date</label>
                    <input class="input" type="date" name="move_out_date" id="move_out_date" value="{{ now()->toDateString() }}">
                </div>
                <div class="field" style="margin-bottom:18px">
                    <label class="label" for="deactivation_reason">Reason</label>
                    <input class="input" type="text" name="deactivation_reason" id="deactivation_reason" placeholder="e.g. Moved out, Lease ended…">
                </div>
                <div class="actions">
                    <button type="submit" class="btn danger">Confirm Archive</button>
                    <button type="button" class="btn" x-on:click="open = false">Cancel</button>
                </div>
            </form>
        </section>
    </div>
@endsection
