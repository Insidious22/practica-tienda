@props([
    'type' => 'info',
    'dismissible' => true,
    'message' => null,
])

<div class="alert alert-{{ $type }} {{ $dismissible ? 'alert-dismissible fade show' : '' }}" role="alert">
    {{ $message ?? $slot }}

    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
