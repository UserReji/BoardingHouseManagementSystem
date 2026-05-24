@extends('layouts.manager', ['title' => 'Receipt Review'])

@section('content')
<div class="page-head"><div><h1 class="page-title">Receipt #{{ $receipt->id }}</h1><p class="muted">{{ $receipt->tenant?->name }} · {{ $receipt->paid_at->format('M d, Y') }}</p></div><x-shared.status-pill :status="$receipt->status" /></div>
<div class="grid grid-2">
<x-receipts.receipt-card :receipt="$receipt">
<p>Bill: {{ $receipt->tenantBill ? '#'.$receipt->tenantBill->id : 'General payment' }}</p>
<p>Notes: {{ $receipt->reviewer_notes ?? '-' }}</p>
</x-receipts.receipt-card>
<x-shared.card>
@if ($receipt->image_path)<img class="photo" src="{{ asset('storage/'.$receipt->image_path) }}" alt="Receipt image">@else<p class="muted">No image uploaded.</p>@endif
</x-shared.card>
</div>
<x-shared.card style="margin-top:16px">
<h3>Decision</h3>
<form method="POST" action="{{ route('manager.receipts.update', $receipt) }}" class="grid">
@csrf @method('PATCH')
<x-forms.select name="decision" label="Decision"><option value="approve">Approve</option><option value="reject">Reject</option></x-forms.select>
<x-forms.textarea name="reviewer_notes" label="Reviewer notes" />
<button class="btn primary" type="submit">Submit decision</button>
</form>
</x-shared.card>
@endsection
