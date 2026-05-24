@extends('layouts.manager', ['title' => 'Edit Tenant'])

@section('content')
<div class="page-head"><h1 class="page-title">Edit Tenant</h1></div>

<form method="POST" action="{{ route('manager.tenants.update', $tenant) }}" class="grid grid-2">
    @csrf
    @method('PATCH')
    <x-forms.input name="name" label="Name" :value="$tenant?->name" required />
    <x-forms.input name="email" label="Email" type="email" :value="$tenant?->email" required />
    <x-forms.input name="password" label="New password" type="password" />
    <x-forms.input name="phone" label="Phone" :value="$tenant?->phone" />
    <x-forms.textarea name="address" label="Address" :value="$tenant?->address" />
    <x-forms.input name="emergency_contact" label="Emergency contact" :value="$tenant?->emergency_contact" />
    <x-forms.select name="room_id" label="Room">
        <option value="">Unassigned</option>
        @foreach ($rooms as $room)
            <option value="{{ $room->id }}" @selected(old('room_id', $tenant?->room_id) == $room->id)>{{ $room->name }}</option>
        @endforeach
    </x-forms.select>
    <x-forms.input name="move_in_date" label="Move in date" type="date" :value="optional($tenant?->move_in_date)->toDateString()" />
    <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $tenant?->is_active ?? true))> Active</label>
    <div><button class="btn primary" type="submit">Update tenant</button></div>
</form>
@endsection
