@extends('layouts.manager', ['title' => 'Archived Tenants'])

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">Archived Tenants</h1>
            <p class="muted">Former renters — all history is preserved.</p>
        </div>
        <a class="btn" href="{{ route('manager.tenants.index') }}">← Back to Active</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Room (Last)</th>
                <th>Move-in</th>
                <th>Move-out</th>
                <th>Reason</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse ($tenants as $tenant)
            <tr>
                <td>
                    <strong>{{ $tenant->name }}</strong>
                    <br><span class="muted">{{ $tenant->email }}</span>
                </td>
                <td>{{ $tenant->room?->name ?? '—' }}</td>
                <td>{{ $tenant->move_in_date?->format('M d, Y') ?? '—' }}</td>
                <td>{{ $tenant->move_out_date?->format('M d, Y') ?? '—' }}</td>
                <td>{{ $tenant->deactivation_reason ?? '—' }}</td>
                <td>
                    <div class="actions">
                        <a class="btn" href="{{ route('manager.tenants.show', $tenant) }}">View</a>

                        {{-- Restore --}}
                        <form method="POST" action="{{ route('manager.tenants.restore', $tenant) }}" style="display:inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn primary">Restore</button>
                        </form>

                        {{-- Permanent Delete --}}
                        <button
                            class="btn danger"
                            x-data
                            x-on:click="$dispatch('open-perm-delete-tenant', { id: {{ $tenant->id }}, name: '{{ addslashes($tenant->name) }}' })"
                        >Delete Forever</button>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="muted" style="text-align:center;padding:32px">No archived tenants.</td></tr>
        @endforelse
        </tbody>
    </table>

    <x-shared.pagination :items="$tenants" />

    {{-- Permanent Delete Modal --}}
    <div
        x-data="{ open: false, tenantId: null, tenantName: '' }"
        x-on:open-perm-delete-tenant.window="open = true; tenantId = $event.detail.id; tenantName = $event.detail.name"
    >
        <div x-show="open" x-cloak style="position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:50"></div>
        <section x-show="open" x-cloak class="card" style="position:fixed;z-index:60;top:12%;left:50%;transform:translateX(-50%);width:min(92vw,480px)">
            <h2 style="margin-top:0;color:var(--danger)">⚠ Permanently Delete Tenant</h2>
            <p>This will <strong>permanently remove</strong> <strong x-text="tenantName"></strong> and cannot be undone. Their bills and receipts may also be affected.</p>
            <form method="POST" :action="'/manager/tenants/' + tenantId + '/force-delete'">
                @csrf @method('DELETE')
                <div class="actions">
                    <button type="submit" class="btn danger">Yes, Delete Permanently</button>
                    <button type="button" class="btn" x-on:click="open = false">Cancel</button>
                </div>
            </form>
        </section>
    </div>
@endsection
