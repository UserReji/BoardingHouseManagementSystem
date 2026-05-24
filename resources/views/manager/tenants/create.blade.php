@extends('layouts.manager', ['title' => 'Add Tenant'])

@section('content')
    <div class="page-head"><h1 class="page-title">Add Tenant</h1></div>
    <form method="POST" action="{{ route('manager.tenants.store') }}" class="grid grid-2">
        @csrf
        <x-forms.input name="name" label="Name" required />
        <x-forms.input name="email" label="Email" type="email" required />
        <x-forms.input name="password" label="Password" type="password" required />
        <x-forms.input name="phone" label="Phone" />
        <x-forms.textarea name="address" label="Address" />
        <x-forms.input name="emergency_contact" label="Emergency contact" />
        <x-forms.select name="room_id" label="Room">
            <option value="">Unassigned</option>
            @foreach ($rooms as $room)
                <option value="{{ $room->id }}" @selected(old('room_id') == $room->id)>{{ $room->name }}</option>
            @endforeach
        </x-forms.select>
        <x-forms.input name="move_in_date" label="Move in date" type="date" />
        <label><input type="checkbox" name="is_active" value="1" checked> Active</label>
        <div><button class="btn primary" type="submit">Create tenant</button></div>
    </form>
@endsection
