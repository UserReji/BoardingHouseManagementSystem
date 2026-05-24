@extends('layouts.tenant', ['title' => 'Meter Readings'])

@section('content')
<div class="page-head"><h1 class="page-title">Meter Readings</h1></div>
<div class="grid grid-2">
@forelse ($readings as $reading)
<x-meters.reading-card :reading="$reading"><a class="btn" href="{{ route('tenant.meter-readings.show', $reading) }}">Open</a></x-meters.reading-card>
@empty
<x-shared.empty-state />
@endforelse
</div>
<x-shared.pagination :items="$readings" />
@endsection
