@extends('layouts.manager', ['title' => 'Billing Periods'])

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">Billing Periods</h1>
            <p class="muted">Open billing windows and due dates.</p>
        </div>
        <div class="actions">
            <a class="btn" href="{{ route('manager.billing-periods.archived') }}">Archived</a>
            <a class="btn primary" href="{{ route('manager.billing-periods.create') }}">+ Add Period</a>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Period Dates</th>
                <th>Due Date</th>
                <th>Bills</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse ($periods as $period)
            <tr>
                <td><a href="{{ route('manager.billing-periods.show', $period) }}"><strong>{{ $period->name }}</strong></a></td>
                <td>{{ $period->starts_at->format('M d') }} – {{ $period->ends_at->format('M d, Y') }}</td>
                <td>{{ $period->due_at->format('M d, Y') }}</td>
                <td>{{ $period->tenant_bills_count }}</td>
                <td>
                    <x-shared.badge :tone="$period->is_closed ? 'muted' : 'success'">
                        {{ $period->is_closed ? 'Closed' : 'Open' }}
                    </x-shared.badge>
                </td>
                <td>
                    <div class="actions">
                        <a class="btn" href="{{ route('manager.billing-periods.edit', $period) }}">Edit</a>
                        <button
                            class="btn danger"
                            x-data
                            x-on:click="$dispatch('open-archive-period', { id: {{ $period->id }}, name: '{{ addslashes($period->name) }}' })"
                        >Archive</button>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="muted" style="text-align:center;padding:32px">No open billing periods found.</td></tr>
        @endforelse
        </tbody>
    </table>

    <x-shared.pagination :items="$periods" />

    {{-- Archive Confirmation Modal --}}
    <div
        x-data="{ open: false, periodId: null, periodName: '' }"
        x-on:open-archive-period.window="open = true; periodId = $event.detail.id; periodName = $event.detail.name"
    >
        <div x-show="open" x-cloak style="position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:50"></div>
        <section x-show="open" x-cloak class="card" style="position:fixed;z-index:60;top:12%;left:50%;transform:translateX(-50%);width:min(92vw,480px)">
            <h2 style="margin-top:0">Archive Billing Period</h2>
            <p>Archive <strong x-text="periodName"></strong>? It will be closed and moved to the archived list. All existing bills will be preserved.</p>
            <form method="POST" :action="'/manager/billing-periods/' + periodId">
                @csrf @method('DELETE')
                <div class="actions">
                    <button type="submit" class="btn danger">Confirm Archive</button>
                    <button type="button" class="btn" x-on:click="open = false">Cancel</button>
                </div>
            </form>
        </section>
    </div>
@endsection
