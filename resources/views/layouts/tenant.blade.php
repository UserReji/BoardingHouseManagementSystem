@extends('layouts.app', ['title' => $title ?? 'Tenant'])

@section('body')
    <div class="app-shell">
        <x-tenant.sidebar />
        <div class="main">
            <x-tenant.topbar :title="$title ?? 'Tenant'" />
            <main class="content">
                <x-shared.alert />
                @yield('content')
            </main>
        </div>
    </div>
    <x-tenant.bottombar />
@endsection
