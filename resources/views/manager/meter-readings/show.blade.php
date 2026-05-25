@extends('layouts.manager', ['title' => 'Meter Reading'])

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">{{ $reading->type->label() }} Reading</h1>
            <p class="muted">{{ $reading->tenant?->name }} · {{ $reading->billingPeriod?->name }}</p>
        </div>
        <div class="actions">
            <a class="btn" href="{{ route('manager.meter-readings.index') }}">← Back</a>
            <a class="btn" href="{{ route('manager.meter-readings.edit', $reading) }}">Edit</a>
            <button class="btn danger" x-data x-on:click="$dispatch('open-delete-reading-show')">Delete</button>
        </div>
    </div>

    <div class="grid grid-2">
        <x-meters.reading-card :reading="$reading" />
        <x-meters.meter-photo :path="$reading->photo_path" />
    </div>

    <div x-data="{ open: false }" x-on:open-delete-reading-show.window="open = true">
        <div x-show="open" x-cloak style="position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:50"></div>
        <section x-show="open" x-cloak class="card" style="position:fixed;z-index:60;top:12%;left:50%;transform:translateX(-50%);width:min(92vw,480px)">
            <h2 style="margin-top:0">Delete Meter Reading</h2>
            <p>Delete this {{ $reading->type->label() }} reading for <strong>{{ $reading->tenant?->name }}</strong>? The photo will also be removed.</p>
            <form method="POST" action="{{ route('manager.meter-readings.destroy', $reading) }}">
                @csrf @method('DELETE')
                <div class="actions">
                    <button type="submit" class="btn danger">Yes, Delete</button>
                    <button type="button" class="btn" x-on:click="open = false">Cancel</button>
                </div>
            </form>
        </section>
    </div>
@endsection
