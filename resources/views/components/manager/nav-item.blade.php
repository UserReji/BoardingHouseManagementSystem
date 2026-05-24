@props(['href', 'active' => false])

<a href="{{ $href }}" class="nav-item {{ $active ? 'active' : '' }}">
    {{ $slot }}
</a>
