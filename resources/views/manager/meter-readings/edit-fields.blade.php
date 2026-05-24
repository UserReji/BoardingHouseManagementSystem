<x-forms.select name="user_id" label="Tenant" required>
@foreach ($tenants as $tenant)<option value="{{ $tenant->id }}" @selected(old('user_id', $reading?->user_id) == $tenant->id)>{{ $tenant->name }}</option>@endforeach
</x-forms.select>
<x-forms.select name="room_id" label="Room">
<option value="">Use tenant room</option>
@foreach ($rooms as $room)<option value="{{ $room->id }}" @selected(old('room_id', $reading?->room_id) == $room->id)>{{ $room->name }}</option>@endforeach
</x-forms.select>
<x-forms.select name="billing_period_id" label="Billing period" required>
@foreach ($periods as $period)<option value="{{ $period->id }}" @selected(old('billing_period_id', $reading?->billing_period_id) == $period->id)>{{ $period->name }}</option>@endforeach
</x-forms.select>
<x-forms.select name="type" label="Type" required>
<option value="electricity" @selected(old('type', $reading?->type?->value) === 'electricity')>Electricity</option>
<option value="water" @selected(old('type', $reading?->type?->value) === 'water')>Water</option>
</x-forms.select>
<x-forms.input name="previous_reading" label="Previous reading" type="number" step="0.01" :value="$reading?->previous_reading ?? 0" required />
<x-forms.input name="current_reading" label="Current reading" type="number" step="0.01" :value="$reading?->current_reading ?? 0" required />
<x-forms.input name="rate" label="Rate" type="number" step="0.01" :value="$reading?->rate ?? 0" required />
<x-forms.input name="read_at" label="Read at" type="date" :value="optional($reading?->read_at)->toDateString()" />
<x-forms.file-upload name="photo" label="Meter photo" accept="image/*" />
<x-forms.textarea name="notes" label="Notes" :value="$reading?->notes" />
