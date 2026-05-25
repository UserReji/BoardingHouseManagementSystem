@extends('layouts.manager', ['title' => 'Bill #'.$bill->id])

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">Bill #{{ $bill->id }}</h1>
            <p class="muted">{{ $bill->tenant?->name }} · {{ $bill->billingPeriod?->name }}</p>
        </div>
        <div class="actions">
            <a class="btn" href="{{ route('manager.tenant-bills.index') }}">← Back</a>
            <a class="btn" href="{{ route('manager.tenant-bills.edit', $bill) }}">Edit</a>
            <button class="btn danger" x-data x-on:click="$dispatch('open-delete-bill-show')">Delete</button>
        </div>
    </div>

    <div class="grid grid-2">
        <x-billing.bill-summary :bill="$bill" />
        <x-billing.due-date-card :bill="$bill" />
    </div>

    <x-shared.card style="margin-top:16px">
        <h3 style="margin-top:0">Receipts</h3>
        @forelse ($bill->receipts as $receipt)
            <p>
                <a href="{{ route('manager.receipts.show', $receipt) }}">{{ $receipt->reference_number ?? 'Receipt #'.$receipt->id }}</a>
                · PHP {{ number_format((float) $receipt->amount, 2) }}
                · <x-shared.badge>{{ $receipt->status->label() }}</x-shared.badge>
            </p>
        @empty
            <p class="muted">No receipts submitted for this bill.</p>
        @endforelse
    </x-shared.card>

    <div x-data="{ open: false }" x-on:open-delete-bill-show.window="open = true">
        <div x-show="open" x-cloak style="position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:50"></div>
        <section x-show="open" x-cloak class="card" style="position:fixed;z-index:60;top:12%;left:50%;transform:translateX(-50%);width:min(92vw,480px)">
            <h2 style="margin-top:0">Delete Bill</h2>
            <p>Delete Bill #{{ $bill->id }} for <strong>{{ $bill->tenant?->name }}</strong>? This cannot be undone.</p>
            <form method="POST" action="{{ route('manager.tenant-bills.destroy', $bill) }}">
                @csrf @method('DELETE')
                <div class="actions">
                    <button type="submit" class="btn danger">Yes, Delete</button>
                    <button type="button" class="btn" x-on:click="open = false">Cancel</button>
                </div>
            </form>
        </section>
    </div>
@endsection
