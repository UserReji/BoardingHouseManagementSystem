@extends('layouts.guest', ['title' => 'Forgot Password'])

@section('content')
    <h1 class="page-title">Forgot password</h1>
    <p class="muted">Password email delivery is not configured yet. Ask the manager to reset your account password.</p>
    <p><a href="{{ route('login') }}">Back to login</a></p>
@endsection
