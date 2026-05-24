@props(['items'])

@if ($items->hasPages())
    <div style="margin-top:16px">
        {{ $items->links() }}
    </div>
@endif
