@extends('layouts.tenant', ['title' => 'Meter Reading'])

@section('content')
<div class="page-head"><div><h1 class="page-title">{{ $reading->type->label() }} Reading</h1><p class="muted">{{ $reading->billingPeriod?->name }}</p></div></div>
<div class="grid grid-2"><x-meters.reading-card :reading="$reading" /><x-meters.meter-photo :path="$reading->photo_path" /></div>
@endsection
