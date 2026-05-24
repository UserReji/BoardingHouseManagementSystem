<x-forms.select name="user_id" label="Tenant" required>
    @foreach ($tenants as $tenant)
        <option value="{{ $tenant->id }}" @selected(old('user_id', $bill?->user_id) == $tenant->id)>{{ $tenant->name }}</option>
    @endforeach
</x-forms.select>
<x-forms.select name="room_id" label="Room">
    <option value="">Use tenant room</option>
    @foreach ($rooms as $room)
        <option value="{{ $room->id }}" @selected(old('room_id', $bill?->room_id) == $room->id)>{{ $room->name }}</option>
    @endforeach
</x-forms.select>
<x-forms.select name="billing_period_id" label="Billing period" required>
    @foreach ($periods as $period)
        <option value="{{ $period->id }}" @selected(old('billing_period_id', $bill?->billing_period_id) == $period->id)>{{ $period->name }}</option>
    @endforeach
</x-forms.select>
<x-forms.input name="rent_amount" label="Rent" type="number" step="0.01" :value="$bill?->rent_amount ?? 0" required />
<x-forms.input name="electricity_amount" label="Electricity" type="number" step="0.01" :value="$bill?->electricity_amount ?? 0" />
<x-forms.input name="water_amount" label="Water" type="number" step="0.01" :value="$bill?->water_amount ?? 0" />
<x-forms.input name="other_charges" label="Other charges" type="number" step="0.01" :value="$bill?->other_charges ?? 0" />
<x-forms.input name="discount_amount" label="Discount" type="number" step="0.01" :value="$bill?->discount_amount ?? 0" />
<x-forms.input name="amount_paid" label="Amount paid" type="number" step="0.01" :value="$bill?->amount_paid ?? 0" />
<x-forms.input name="due_at" label="Due date" type="date" :value="optional($bill?->due_at)->toDateString()" />
<x-forms.textarea name="notes" label="Notes" :value="$bill?->notes" />
