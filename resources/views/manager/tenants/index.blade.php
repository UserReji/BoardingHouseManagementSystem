@extends('layouts.manager', ['title' => 'Tenants'])

@section('content')
    <div class="page-head">
        <div><h1 class="page-title">Tenants</h1><p class="muted">Manage renter profiles and assigned rooms.</p></div>
        <a class="btn primary" href="{{ route('manager.tenants.create') }}">Add tenant</a>
    </div>

    <table class="table">
        <thead><tr><th>Name</th><th>Room</th><th>Phone</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @forelse ($tenants as $tenant)
            <tr>
                <td><a href="{{ route('manager.tenants.show', $tenant) }}">{{ $tenant->name }}</a><br><span class="muted">{{ $tenant->email }}</span></td>
                <td>{{ $tenant->room?->name ?? 'Unassigned' }}</td>
                <td>{{ $tenant->phone ?? '-' }}</td>
                <td><x-shared.badge :tone="$tenant->is_active ? 'success' : 'muted'">{{ $tenant->is_active ? 'Active' : 'Inactive' }}</x-shared.badge></td>
                <td><a class="btn" href="{{ route('manager.tenants.edit', $tenant) }}">Edit</a></td>
            </tr>
        @empty
            <tr><td colspan="5">No tenants found.</td></tr>
        @endforelse
        </tbody>
    </table>
    <x-shared.pagination :items="$tenants" />
@endsection
