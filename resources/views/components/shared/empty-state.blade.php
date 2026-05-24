@props(['title' => 'Nothing here yet', 'message' => 'Records will appear here once they are created.'])

<div class="card" style="text-align:center">
    <h3>{{ $title }}</h3>
    <p class="muted">{{ $message }}</p>
    {{ $slot }}
</div>
