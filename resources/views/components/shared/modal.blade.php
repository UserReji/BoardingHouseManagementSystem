@props(['name'])

<div x-data="{ open: false }" x-on:open-{{ $name }}.window="open = true">
    <div x-show="open" x-cloak style="position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:50"></div>
    <section x-show="open" x-cloak class="card" style="position:fixed;z-index:60;top:12%;left:50%;transform:translateX(-50%);width:min(92vw,520px)">
        {{ $slot }}
        <button type="button" class="btn" x-on:click="open = false">Close</button>
    </section>
</div>
