@extends('layouts.tenant', ['title' => 'My Profile'])

@section('content')
<div class="page-head"><h1 class="page-title">My Profile</h1></div>
<form method="POST" action="{{ route('tenant.profile.update') }}" class="grid grid-2">
@csrf @method('PATCH')
<x-forms.input name="name" label="Name" :value="$tenant->name" required />
<x-forms.input name="phone" label="Phone" :value="$tenant->phone" />
<x-forms.textarea name="address" label="Address" :value="$tenant->address" />
<x-forms.input name="emergency_contact" label="Emergency contact" :value="$tenant->emergency_contact" />
<x-shared.card><h3>Room</h3><p>{{ $tenant->room?->name ?? 'No room assigned' }}</p></x-shared.card>
<div><button class="btn primary" type="submit">Update profile</button></div>
</form>
@endsection
