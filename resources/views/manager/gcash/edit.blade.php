@extends('layouts.manager', ['title' => 'Edit GCash'])

@section('content')
<div class="page-head"><h1 class="page-title">Edit GCash</h1></div>
<form method="POST" action="{{ route('manager.gcash.update', $account) }}" enctype="multipart/form-data" class="grid grid-2">
@csrf @method('PATCH')
<x-forms.input name="account_name" label="Account name" :value="$account->account_name" required />
<x-forms.input name="account_number" label="Account number" :value="$account->account_number" required />
<x-forms.textarea name="instructions" label="Instructions" :value="$account->instructions" />
<x-forms.file-upload name="qr" label="QR image" accept="image/*" />
<label><input type="checkbox" name="is_active" value="1" @checked($account->is_active)> Active</label>
<div><button class="btn primary" type="submit">Update GCash</button></div>
</form>
@endsection
