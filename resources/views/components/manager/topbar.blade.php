<header class="topbar">
    <div>
        <strong>{{ $title ?? 'Manager' }}</strong>
        <div class="muted">{{ now()->format('F j, Y') }}</div>
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn" type="submit">Logout</button>
    </form>
</header>
