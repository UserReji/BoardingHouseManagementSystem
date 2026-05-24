@extends('layouts.tenant', ['title' => 'Upload Receipt'])

@section('content')
<div class="page-head"><h1 class="page-title">Upload Receipt</h1></div>
<x-receipts.receipt-upload :bills="$bills" :action="route('tenant.receipts.store')" />
@endsection
