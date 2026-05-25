@extends('layouts.manager', ['title' => 'Meter Readings'])

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">Meter Readings</h1>
            <p class="muted">Electricity and water readings per tenant.</p>
        </div>
        <a class="btn primary" href="{{ route('manager.meter-readings.create') }}">+ Add Reading</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Tenant</th>
                <th>Room</th>
                <th>Type</th>
                <th>Period</th>
                <th>Usage</th>
                <th>Amount</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse ($readings as $reading)
            <tr>
                <td>{{ $reading->tenant?->name ?? '—' }}</td>
                <td>{{ $reading->room?->name ?? '—' }}</td>
                <td>{{ $reading->type->label() }}</td>
                <td>{{ $reading->billingPeriod?->name ?? '—' }}</td>
                <td>{{ number_format($reading->usage, 2) }} {{ $reading->type->unit() }}</td>
                <td>PHP {{ number_format((float) $reading->amount, 2) }}</td>
                <td>
                    <div class="actions">
                        <a class="btn" href="{{ route('manager.meter-readings.show', $reading) }}">View</a>
                        <a class="btn" href="{{ route('manager.meter-readings.edit', $reading) }}">Edit</a>
                        <button
                            class="btn danger"
                            x-data
                            x-on:click="$dispatch('open-delete-reading', { id: {{ $reading->id }} })"
                        >Delete</button>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="muted" style="text-align:center;padding:32px">No readings found.</td></tr>
        @endforelse
        </tbody>
    </table>

    <x-shared.pagination :items="$readings" />

    {{-- Delete Modal --}}
    <div
        x-data="{ open: false, readingId: null }"
        x-on:open-delete-reading.window="open = true; readingId = $event.detail.id"
    >
        <div x-show="open" x-cloak style="position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:50"></div>
        <section x-show="open" x-cloak class="card" style="position:fixed;z-index:60;top:12%;left:50%;transform:translateX(-50%);width:min(92vw,480px)">
            <h2 style="margin-top:0">Delete Meter Reading</h2>
            <p>Are you sure you want to delete this meter reading? This cannot be undone.</p>
            <form method="POST" :action="'/manager/meter-readings/' + readingId">
                @csrf @method('DELETE')
                <div class="actions">
                    <button type="submit" class="btn danger">Yes, Delete</button>
                    <button type="button" class="btn" x-on:click="open = false">Cancel</button>
                </div>
            </form>
        </section>
    </div>
@endsection
