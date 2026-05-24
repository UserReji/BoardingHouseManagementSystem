@extends('layouts.app', ['title' => $title ?? 'Welcome'])

@section('body')
    <main class="auth-wrap">
        <section class="auth-card card">
            <x-shared.app-logo />
            <x-shared.alert />
            @yield('content')
        </section>
    </main>
@endsection
