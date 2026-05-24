@extends('layouts.app', ['title' => $title ?? 'Manager'])

@section('body')
    <div class="app-shell">
        <x-manager.sidebar />
        <div class="main">
            <x-manager.topbar :title="$title ?? 'Manager'" />
            <main class="content">
                <x-shared.alert />
                @yield('content')
            </main>
        </div>
    </div>
    <x-manager.bottombar />
@endsection
