@props(['bills' => collect(), 'action'])

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="grid">
    @csrf
    <x-forms.select name="tenant_bill_id" label="Bill">
        <option value="">General payment</option>
        @foreach ($bills as $bill)
            <option value="{{ $bill->id }}">Bill #{{ $bill->id }} - PHP {{ number_format($bill->balance, 2) }}</option>
        @endforeach
    </x-forms.select>
    <x-forms.input name="amount" label="Amount" type="number" step="0.01" required />
    <x-forms.input name="reference_number" label="Reference number" />
    <x-forms.input name="paid_at" label="Paid at" type="date" :value="now()->toDateString()" required />
    <x-forms.file-upload name="receipt" label="Receipt image" accept="image/*" />
    <button class="btn primary" type="submit">Submit receipt</button>
</form>
