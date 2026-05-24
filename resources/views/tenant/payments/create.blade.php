@extends('layouts.tenant', ['title' => 'Upload Payment'])

@section('content')
<div class="page-head"><h1 class="page-title">Upload Payment</h1></div>
<x-receipts.receipt-upload :bills="$bills" :action="route('tenant.payments.store')" />
@endsection
