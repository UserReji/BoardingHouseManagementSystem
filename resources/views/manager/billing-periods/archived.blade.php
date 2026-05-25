@extends('layouts.manager', ['title' => 'Archived Billing Periods'])

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">Archived Billing Periods</h1>
            <p class="muted">Closed periods — all bill records are preserved.</p>
        </div>
        <a class="btn" href="{{ route('manager.billing-periods.index') }}">← Back to Active</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Period Dates</th>
                <th>Due Date</th>
                <th>Bills</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse ($periods as $period)
            <tr>
                <td><strong>{{ $period->name }}</strong></td>
                <td>{{ $period->starts_at->format('M d') }} – {{ $period->ends_at->format('M d, Y') }}</td>
                <td>{{ $period->due_at->format('M d, Y') }}</td>
                <td>{{ $period->tenant_bills_count }}</td>
                <td>
                    <div class="actions">
                        {{-- Restore --}}
                        <form method="POST" action="{{ route('manager.billing-periods.restore', $period->id) }}" style="display:inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn primary">Restore</button>
                        </form>

                        {{-- Permanent Delete --}}
                        <button
                            class="btn danger"
                            x-data
                            x-on:click="$dispatch('open-perm-delete-period', { id: {{ $period->id }}, name: '{{ addslashes($period->name) }}' })"
                        >Delete Forever</button>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="muted" style="text-align:center;padding:32px">No archived billing periods.</td></tr>
        @endforelse
        </tbody>
    </table>

    <x-shared.pagination :items="$periods" />

    {{-- Permanent Delete Modal --}}
    <div
        x-data="{ open: false, periodId: null, periodName: '' }"
        x-on:open-perm-delete-period.window="open = true; periodId = $event.detail.id; periodName = $event.detail.name"
    >
        <div x-show="open" x-cloak style="position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:50"></div>
        <section x-show="open" x-cloak class="card" style="position:fixed;z-index:60;top:12%;left:50%;transform:translateX(-50%);width:min(92vw,480px)">
            <h2 style="margin-top:0;color:var(--danger)">⚠ Permanently Delete Period</h2>
            <p><strong x-text="periodName"></strong> and all its associated bill records will be permanently deleted. This cannot be undone.</p>
            <form method="POST" :action="'/manager/billing-periods/' + periodId + '/force-delete'">
                @csrf @method('DELETE')
                <div class="actions">
                    <button type="submit" class="btn danger">Yes, Delete Permanently</button>
                    <button type="button" class="btn" x-on:click="open = false">Cancel</button>
                </div>
            </form>
        </section>
    </div>
@endsection
