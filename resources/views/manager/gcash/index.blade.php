@extends('layouts.manager', ['title' => 'GCash Accounts'])

@section('content')
<div class="page-head"><div><h1 class="page-title">GCash Accounts</h1><p class="muted">Payment destination details shown to tenants.</p></div></div>
<table class="table"><thead><tr><th>Name</th><th>Number</th><th>Status</th><th></th></tr></thead><tbody>
@forelse ($accounts as $account)
<tr><td>{{ $account->account_name }}</td><td>{{ $account->account_number }}</td><td><x-shared.badge :tone="$account->is_active ? 'success' : 'muted'">{{ $account->is_active ? 'Active' : 'Inactive' }}</x-shared.badge></td><td><a class="btn" href="{{ route('manager.gcash.edit', $account) }}">Edit</a></td></tr>
@empty
<tr><td colspan="4">No GCash accounts found. Seed the database to create the first account.</td></tr>
@endforelse
</tbody></table>
<x-shared.pagination :items="$accounts" />
@endsection
