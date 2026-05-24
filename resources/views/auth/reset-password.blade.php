@extends('layouts.guest', ['title' => 'Reset Password'])

@section('content')
    <h1 class="page-title">Reset password</h1>
    <p class="muted">Reset links are reserved for a future mail setup.</p>
    <p><a href="{{ route('login') }}">Back to login</a></p>
@endsection
