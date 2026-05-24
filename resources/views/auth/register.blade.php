@extends('layouts.guest', ['title' => 'Register'])

@section('content')
    <h1 class="page-title">Create tenant account</h1>

    <form method="POST" action="{{ route('register.store') }}" class="grid">
        @csrf
        <x-forms.input name="name" label="Full name" required />
        <x-forms.input name="email" label="Email" type="email" required />
        <x-forms.input name="password" label="Password" type="password" required />
        <x-forms.input name="password_confirmation" label="Confirm password" type="password" required />
        <button class="btn primary" type="submit">Register</button>
    </form>

    <p><a href="{{ route('login') }}">Back to login</a></p>
@endsection
