<header class="topbar">
    <div>
        <strong>{{ $title ?? 'Tenant' }}</strong>
        <div class="muted">{{ auth()->user()->room?->name ?? 'No room assigned' }}</div>
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn" type="submit">Logout</button>
    </form>
</header>
