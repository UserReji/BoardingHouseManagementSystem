@extends('layouts.guest', ['title' => 'Login'])

@section('content')
    <h1 class="page-title">Sign in</h1>
    <p class="muted">Use your manager or tenant account.</p>

    <form method="POST" action="{{ route('login.store') }}" class="grid">
        @csrf
        <x-forms.input name="email" label="Email" type="email" required autofocus />
        <x-forms.input name="password" label="Password" type="password" required />
        <label><input type="checkbox" name="remember" value="1"> Remember me</label>
        <button class="btn primary" type="submit">Login</button>
    </form>

    <p><a href="{{ route('register') }}">Create tenant account</a></p>
@endsection
